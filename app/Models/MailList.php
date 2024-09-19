<?php

namespace App\Models;

use App\Services\CommonServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailList extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'sid';

    protected $guarded = [
        'sid',
    ];

    protected $dates = [
        'send_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'level' => 'array',
    ];

    protected static function booted()
    {
        parent::boot();

        static::deleting(function ($mail) {
            // 발송 이력 있을경우 삭제
            $mail->totMail()->delete();

            // 첨부파일 있을경우 하나씩 삭제
            $mail->files()->each(function ($file) {
                $file->delete();
            });
        });

        static::saved(function ($mail) {
            $data = request();
            $plupload_file = $data->plupload_file;
            $plupload_file_del = $data->plupload_file_del;

            $ml_sid = $mail->sid;

            if (!empty($plupload_file)) {
                /* 첨부파일 (plupload) */
                foreach (json_decode($plupload_file, true) as $row) {
                    $file = new MailFile();
                    $file->setByData($row, $ml_sid);
                    $file->save();
                }
            }

            if (!empty($plupload_file_del)) {
                // 첨부파일 (plupload) 삭제
                foreach ($mail->files()->whereIn('sid', $plupload_file_del)->get() as $plFile) {
                    $plFile->delete();
                }
            }
        });
    }

    protected static function mailConfig()
    {
        return getConfig('mail');
    }

    public function setByData($data)
    {
        $this->subject = $data['subject']; // 메일 제목
        $this->sender_name = $data['sender_name']; // 발송자
        $this->sender_email = $data['sender_email']; // 발송자 메일

        $this->send_type = $data['send_type']; // 메일 발송 타입;

        $this->level = ($this->send_type == 1) ? $data['level'] : null; // 등급별 발송일 경우
        $this->ma_sid = ($this->send_type == 2) ? $data['ma_sid'] : null; // 주소록 발송일 경우
        $this->test_email = ($this->send_type == 9) ? $data['test_email'] : null; // 테스트 발송일 경우

        $this->template = $data['template']; // 메일 템플릿
        $this->use_btn = $data['use_btn']; // 버튼 사용;

        $this->link_url = ($this->use_btn == 9) ? null : $data['link_url']; // 버튼사용 할때 링크

        $this->contents = $data['contents']; // 메일 내용

        if ($data['send'] === 'Y') { // 발송 할때
            $thread = $this->thread ?? 0;

            $this->send_date = now();
            $this->thread = ($thread + 1);
        }
    }

    public function files()
    {
        return $this->hasMany(MailFile::class, 'ml_sid');
    }

    public function totMail()
    {
        return $this->hasMany(MailSend::class, 'ml_sid');
    }

    public function sucMail()
    {
        return $this->hasMany(MailSend::class, 'ml_sid')->where('status', 'S');
    }

    public function failMail()
    {
        return $this->hasMany(MailSend::class, 'ml_sid')->where('status', 'F');
    }

    public function readyMail()
    {
        return $this->hasMany(MailSend::class, 'ml_sid')->where('status', 'R');
    }
}

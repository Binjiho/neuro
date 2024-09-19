<style>
    #spinner-div {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 9999;
    }

    .spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .spinner-dot {
        width: 20px;
        height: 20px;
        background-color: #e27f5c;
        border-radius: 50%;
        position: absolute;
        animation: bounce 1s infinite alternate;
    }

    .spinner-dot:nth-child(1) {
        animation-delay: 0s;
    }

    .spinner-dot:nth-child(2) {
        animation-delay: 0.1s;
    }

    .spinner-dot:nth-child(3) {
        animation-delay: 0.2s;
    }

    @keyframes bounce {
        0% {
            transform: translateY(0);
        }
        100% {
            transform: translateY(-15px);
        }
    }
</style>

<div id="spinner-div">
    <div class="spinner">
        <div class="spinner-dot"></div>
        <div class="spinner-dot" style="left: 30px;"></div>
        <div class="spinner-dot" style="left: 60px;"></div>
    </div>
</div>

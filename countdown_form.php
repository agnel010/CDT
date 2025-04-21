<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countdown Timer</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Inter", "Poppins", -apple-system, BlinkMacSystemFont, sans-serif;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    .outer-box {
        width: 100%;
        max-width: 420px;
        background: linear-gradient(135deg, #7b2cbf 0%, #5a189a 100%);
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2),
                   0 1px 3px rgba(0, 0, 0, 0.1);
        text-align: center;
        color: #ffffff;
        transition: transform 0.2s ease, max-width 0.3s ease, padding 0.3s ease, min-height 0.3s ease;
        min-height: 500px;
    }

    .outer-box:hover {
        transform: translateY(-2px);
    }

    h1 {
        color: #ffffff;
        margin-bottom: 1.5rem;
        font-size: 1.75rem;
        font-weight: 600;
        letter-spacing: -0.025em;
    }

    p {
        margin-bottom: 1rem;
        color: #d8b4fe;
        font-size: 0.95rem;
    }

    .instructions {
        color: #ffffff;
        font-weight: bold;
    }

    #countdown-form {
        background: linear-gradient(135deg, #9f7aea 0%, #6d28d9 100%);
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    input, button {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    #countdown-form input {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #d6bcfa;
        text-align: center;
        color: #2d3748;
    }

    #countdown-form input:focus {
        outline: none;
        border-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
    }

    .preview {
        font-size: 1.1rem;
        font-weight: 500;
        color: #ffffff;
        margin: 1rem 0;
        padding: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 6px;
    }

    #countdown-form button[type="submit"] {
        background: linear-gradient(135deg, #48bb78 0%, #2f855a 100%);
        border: none;
        color: #ffffff;
        cursor: pointer;
        font-weight: 500;
        padding: 12px;
    }

    #countdown-form button[type="submit"]:hover {
        background: linear-gradient(135deg, #38a169 0%, #276749 100%);
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    #countdown-form button[type="submit"]:active {
        transform: scale(0.98);
    }

    #logout-button, #history-button {
        background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
        border: none;
        color: #ffffff;
        cursor: pointer;
        font-weight: 500;
        padding: 12px;
    }

    #logout-button:hover, #history-button:hover {
        background: linear-gradient(135deg, #c53030 0%, #9b2c2c 100%);
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    #logout-button:active, #history-button:active {
        transform: scale(0.98);
    }

    #history-button {
        background: linear-gradient(135deg, #5A67D8 0%, #4C51BF 100%);
    }

    #history-button:hover {
        background: linear-gradient(135deg, #4C51BF 0%, #434190 100%);
    }

    .button-group {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .button-group button {
        flex: 1;
    }

    #countdown-section {
        display: none;
        padding: 1.5rem 0;
        text-align: center;
        transition: all 0.3s ease;
    }

    #countdown-section.active {
        display: block;
    }

    #countdown-display {
        font-size: 3.5rem;
        font-weight: 700;
        margin: 2rem 0;
        color: #ffffff;
        font-family: 'monospace', sans-serif;
        letter-spacing: 4px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.4));
        padding: 1.5rem 2rem;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3), inset 0 0 12px rgba(255, 255, 255, 0.2);
        animation: pulse 2s infinite;
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.03); }
        100% { transform: scale(1); }
    }

    #countdown-display::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: rotate 10s linear infinite;
        z-index: 0;
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    #countdown-display span {
        position: relative;
        z-index: 1;
    }

    .controls {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin: 1.5rem 0;
        flex-wrap: wrap;
    }

    .controls button {
        background: linear-gradient(135deg, #a78bfa, #6b46c1);
        border: none;
        color: white;
        cursor: pointer;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        min-width: 100px;
    }

    .controls button:hover {
        background: linear-gradient(135deg, #8b5cf6, #553c9a);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .controls button:active {
        transform: translateY(0);
    }

    #status {
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 20px;
        font-size: 1.1rem;
        display: inline-block;
        background: linear-gradient(135deg, #a0aec0, #4a5568);
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: background 0.3s ease;
        margin-top: 1rem;
    }

    #status.paused {
        background: linear-gradient(135deg, #f6ad55, #ed8936);
    }

    #status.completed {
        background: linear-gradient(135deg, #48bb78, #2f855a);
    }

    p[style="display: block;"] {
        color: #d8b4fe;
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        text-shadow: 0 0 5px rgba(216, 180, 254, 0.5);
    }

    #progress-ring {
        width: 140px;
        height: 140px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }

    #progress-ring circle {
        fill: none;
        stroke: rgba(255, 255, 255, 0.3);
        stroke-width: 6;
        stroke-linecap: round;
        transform: rotate(-90deg);
        transform-origin: center;
        animation: progress 10s linear infinite;
    }

    @keyframes progress {
        0% { stroke-dasharray: 0 439; }
        100% { stroke-dasharray: 439 439; }
    }

    .circle {
        width: 250px;
        height: 250px;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.3));
        position: fixed;
        animation: float 6s ease-in-out infinite;
    }

    .c1 {
        top: 50px;
        left: 40px;
        animation-delay: 0s;
    }

    .c2 {
        bottom: 50px;
        right: 50px;
        animation-delay: 0s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-30px); }
    }

    @media (max-width: 480px) {
        .outer-box {
            padding: 1.5rem;
            min-height: 400px;
        }
        
        h1 {
            font-size: 1.5rem;
        }
        
        #countdown-display {
            font-size: 2.5rem;
            padding: 1rem 1.5rem;
        }
        
        .controls button {
            padding: 10px 20px;
            min-width: 90px;
        }
        
        #progress-ring {
            width: 100px;
            height: 100px;
        }

        .button-group {
            flex-direction: column;
            gap: 8px;
        }
    }
    </style>
</head>
<body>
<div class="outer-box">
    <h1 id="countdown-title">Set a Countdown</h1>
    <p id="countdown-instructions" class="instructions">Enter the countdown details below</p>

    <div id="message"></div>

    <form id="countdown-form" method="POST" action="save_countdown.php">
        <input type="text" id="countdown_name" name="countdown_name" placeholder="Countdown Name" required>
        <input type="number" id="hours" name="hours" min="0" max="24" placeholder="Hours" required>
        <input type="number" id="minutes" name="minutes" min="0" max="59" placeholder="Minutes" required>
        <input type="number" id="seconds" name="seconds" min="0" max="59" placeholder="Seconds" required>
        <div class="preview">Preview: <span id="preview-time">00:00:00</span></div>
        <button type="submit">Start Countdown</button>
        <div class="button-group">
            <button type="button" id="logout-button">Logout</button>
            <button type="button" id="history-button" onclick="window.location.href='history.php'">History</button>
        </div>
    </form>

    <div id="countdown-section">
        <p style="display: block;">Live Countdown</p>
        <div id="countdown-display">
            <span>00:00:00</span>
            <svg id="progress-ring" width="140" height="140">
                <circle cx="70" cy="70" r="65" />
            </svg>
        </div>
        <div class="controls">
            <button onclick="pauseCountdown()">Pause</button>
            <button onclick="resumeCountdown()">Resume</button>
            <button onclick="resetCountdown()">Reset</button>
        </div>
        <p>Status: <span id="status">Live</span></p>
    </div>
</div>

<div class="circle c1"></div>
<div class="circle c2"></div>

<script>
    let countdownInterval;
    let timeRemaining;
    let isPaused = false;
    let countdownId = null;

    function updatePreview() {
        const hours = String(document.getElementById("hours").value || 0).padStart(2, '0');
        const minutes = String(document.getElementById("minutes").value || 0).padStart(2, '0');
        const seconds = String(document.getElementById("seconds").value || 0).padStart(2, '0');
        document.getElementById("preview-time").textContent = `${hours}:${minutes}:${seconds}`;
    }

    function startCountdown(hours, minutes, seconds, name, id) {
        countdownId = id;
        document.getElementById("countdown-title").style.display = "none";
        document.getElementById("countdown-instructions").style.display = "none";
        document.getElementById("countdown-form").style.display = "none";
        const countdownSection = document.getElementById("countdown-section");
        countdownSection.style.display = "block";
        countdownSection.classList.add("active");

        const outerBox = document.querySelector(".outer-box");
        outerBox.style.maxWidth = "400px";
        outerBox.style.minHeight = "450px";
        outerBox.style.padding = "1.5rem";

        timeRemaining = (hours * 3600) + (minutes * 60) + seconds;
        updateCountdownDisplay();

        countdownInterval = setInterval(() => {
            if (!isPaused && timeRemaining > 0) {
                timeRemaining--;
                updateCountdownDisplay();
                if (timeRemaining <= 0) {
                    clearInterval(countdownInterval);
                    document.getElementById("status").textContent = "Completed";
                    document.getElementById("status").classList.add("completed");
                    updateStatus('completed');
                    alert(name + " countdown completed!");
                }
            }
        }, 1000);
    }

    function updateCountdownDisplay() {
        let hours = Math.floor(timeRemaining / 3600);
        let minutes = Math.floor((timeRemaining % 3600) / 60);
        let seconds = timeRemaining % 60;
        document.getElementById("countdown-display").innerHTML =
            `<span>${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}</span>
             <svg id="progress-ring" width="140" height="140">
                <circle cx="70" cy="70" r="65" />
             </svg>`;
    }

    function updateStatus(newStatus) {
        if (!countdownId) return;

        const formData = new FormData();
        formData.append('countdown_id', countdownId);
        formData.append('status', newStatus);

        fetch('update_status.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (!data || !data.success) {
                console.error('Status update failed:', data?.message || 'No data returned');
            }
        })
        .catch(error => console.error('Error updating status:', error));
    }

    function pauseCountdown() {
        isPaused = true;
        document.getElementById("status").textContent = "Paused";
        document.getElementById("status").classList.add("paused");
        updateStatus('paused');
    }

    function resumeCountdown() {
        isPaused = false;
        document.getElementById("status").textContent = "Live";
        document.getElementById("status").classList.remove("paused", "completed");
        updateStatus('active');
    }

    function resetCountdown() {
        clearInterval(countdownInterval);
        document.getElementById("countdown-section").style.display = "none";
        document.getElementById("countdown-section").classList.remove("active");
        document.getElementById("countdown-title").style.display = "block";
        document.getElementById("countdown-instructions").style.display = "block";
        document.getElementById("countdown-form").style.display = "block";
        
        const outerBox = document.querySelector(".outer-box");
        outerBox.style.maxWidth = "420px";
        outerBox.style.minHeight = "500px"; // Fixed typo from min-height to minHeight
        outerBox.style.padding = "2rem";
        
        document.getElementById("status").textContent = "Live";
        document.getElementById("status").classList.remove("paused", "completed");
        countdownId = null;
        timeRemaining = null; // Reset timeRemaining
    }

    // Add event listeners after DOM is fully loaded
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById("hours").addEventListener("input", updatePreview);
        document.getElementById("minutes").addEventListener("input", updatePreview);
        document.getElementById("seconds").addEventListener("input", updatePreview);

        document.getElementById("countdown-form").addEventListener("submit", function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            
            fetch("save_countdown.php", {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                const messageDiv = document.getElementById("message");
                messageDiv.innerHTML = '';
                
                if (data && data.success) {
                    messageDiv.innerHTML = '<div class="success">' + data.message + '</div>';
                    const hours = parseInt(formData.get("hours")) || 0;
                    const minutes = parseInt(formData.get("minutes")) || 0;
                    const seconds = parseInt(formData.get("seconds")) || 0;
                    const name = formData.get("countdown_name");
                    startCountdown(hours, minutes, seconds, name, data.countdown_id);
                } else {
                    messageDiv.innerHTML = '<div class="error">' + (data?.message || 'Unknown error') + '</div>';
                    console.log("Server response:", data);
                }
                setTimeout(() => messageDiv.innerHTML = '', 3000);
            })
            .catch(error => {
                console.error("Fetch error:", error);
                const messageDiv = document.getElementById("message");
                messageDiv.innerHTML = '<div class="error">Error: ' + error.message + '</div>';
                setTimeout(() => messageDiv.innerHTML = '', 3000);
            });
        });

        document.getElementById("logout-button").addEventListener("click", function() {
            window.location.href = "login.php";
        });
    });
</script>
</body>
</html>
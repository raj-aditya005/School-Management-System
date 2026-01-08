<!-- 🤖 Floating AI Widget -->
<div id="ai-float" onclick="toggleAI()">
  <svg width="34" height="34" viewBox="0 0 100 100" id="ai-face">

    <!-- Face -->
    <circle cx="50" cy="50" r="45" fill="#EEF2FF"/>

    <!-- Eyes -->
    <circle id="eye-left" class="eye" cx="35" cy="45" r="5" fill="#4F46E5"/>
    <circle id="eye-right" class="eye" cx="65" cy="45" r="5" fill="#4F46E5"/>

    <!-- Mouth -->
    <path id="mouth"
      d="M35 65 Q50 75 65 65"
      stroke="#4F46E5"
      stroke-width="4"
      fill="none"/>
  </svg>
</div>



<div id="ai-chat">
  <div class="ai-header">
    AI Assistant
    <span onclick="toggleAI()">✖</span>
  </div>

  <div class="ai-body">
    <div class="ai-msg bot">Hi 👋 I’m your assistant.</div>
    <div class="ai-msg bot">I can help guide you through the system.</div>
  </div>

  <input type="text" id="ai-input" class="ai-input" placeholder="Type here…" />
</div>

<style>
    /* Floating AI circle already exists */
#ai-float svg {
  animation: blink 4s infinite;
}

/* Eye blinking */
.eye {
  transform-origin: center;
  animation: eyeBlink 4s infinite;
}

@keyframes eyeBlink {
  0%, 90%, 100% { transform: scaleY(1); }
  92%, 96% { transform: scaleY(0.1); }
}
#ai-float::after {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: rgba(79,70,229,0.4);
  animation: pulse 2.5s infinite;
  z-index: -1;
}

@keyframes pulse {
  0% { transform: scale(1); opacity: 0.6; }
  100% { transform: scale(1.6); opacity: 0; }
}

/* 🔵 Floating AI Circle */
#ai-float {
  position: fixed;
  bottom: 25px;
  right: 25px;
  width: 60px;
  height: 60px;
  background: #4f46e5;
  color: #fff;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 26px;
  cursor: pointer;
  z-index: 9999;
  animation: floatAI 3s ease-in-out infinite;
  box-shadow: 0 10px 25px rgba(0,0,0,0.25);
}

/* Floating animation */
@keyframes floatAI {
  0%   { transform: translateY(0); }
  50%  { transform: translateY(-8px); }
  100% { transform: translateY(0); }
}

/* 🧠 Chat Box */
#ai-chat {
  position: fixed;
  bottom: 100px;
  right: 25px;
  width: 300px;
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 15px 40px rgba(0,0,0,0.3);
  overflow: hidden;
  display: none;
  z-index: 9999;
  animation: popUp 0.3s ease;
}

@keyframes popUp {
  from { transform: scale(0.9); opacity: 0; }
  to   { transform: scale(1); opacity: 1; }
}

/* Header */
.ai-header {
  background: #4f46e5;
  color: #fff;
  padding: 10px 12px;
  font-weight: 600;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Body */
.ai-body {
  height: 200px;
  padding: 10px;
  overflow-y: auto;
  font-size: 14px;
}

/* Messages */
.ai-msg {
  margin-bottom: 8px;
  padding: 6px 10px;
  border-radius: 8px;
}

.ai-msg.bot {
  background: #eef2ff;
}

/* Input */
.ai-input {
  width: 100%;
  border: none;
  border-top: 1px solid #ddd;
  padding: 10px;
  outline: none;
}
.ai-msg.user {
  background: #e0e7ff;
  text-align: right;
}
/* When user is typing */
#ai-face.typing .eye {
  transform: scale(3s);
  transition: transform 0.5s ease;
}

/* Smile change */
#ai-face.typing #mouth {
  d: path("M30 63 Q50 80 70 63");
  transition: all 0.2s ease;
}


</style>

<script>
function toggleAI() {
  const chat = document.getElementById("ai-chat");
  chat.style.display = chat.style.display === "block" ? "none" : "block";
}

/* INPUT + RESPONSE */
const input = document.getElementById("ai-input");
const body = document.querySelector(".ai-body");

input.addEventListener("keydown", function(e) {
  if (e.key === "Enter" && input.value.trim() !== "") {

    const userMsg = input.value.trim();

    // show user message
    body.innerHTML += `
      <div class="ai-msg user">
        <b>You:</b> ${userMsg}
      </div>
    `;

    input.value = "";

    // basic AI replies (rule based)
    let reply = "I am here to help 🙂";

    const msg = userMsg.toLowerCase();

    if (msg.includes("attendance"))
      reply = "You can mark attendance from the Teacher panel.";
    else if (msg.includes("class"))
      reply = "Select a class from the dropdown to load students.";
    else if (msg.includes("report"))
      reply = "Attendance reports are available in the Report section.";
    else if (msg.includes("login"))
      reply = "Use your username and password to login.";
    else if (msg.includes("fees"))
      reply = "Fees details are available in the admin panel.";

    // show bot reply
    setTimeout(() => {
      body.innerHTML += `
        <div class="ai-msg bot">
          <b>AI:</b> ${reply}
        </div>
      `;
      body.scrollTop = body.scrollHeight;
    }, 400);
  }
});
const aiFace = document.getElementById("ai-face");
let typingTimer;

/* detect typing */
input.addEventListener("input", () => {
  aiFace.classList.add("typing");

  clearTimeout(typingTimer);
  typingTimer = setTimeout(() => {
    aiFace.classList.remove("typing");
  }, 700);
});

</script>


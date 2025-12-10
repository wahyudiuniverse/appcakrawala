<!-- 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Server Bermasalah</title>
  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
      font-family: "Poppins", sans-serif;
      color: #333;
    }

    .container {
      text-align: center;
      background: #fff;
      padding: 40px 60px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      max-width: 400px;
    }

    h1 {
      font-size: 22px;
      margin-bottom: 10px;
    }

    p {
      font-size: 14px;
      color: #666;
      margin-bottom: 25px;
    }

    button {
      background-color: #4a90e2;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
      font-size: 14px;
    }

    button:hover {
      background-color: #357ab8;
    }

    .icon {
      font-size: 50px;
      margin-bottom: 15px;
      color: #ff6b6b;
    }
  </style>
</head> -->
<!-- <body> -->

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Time Restriction</title>
  <style>
    :root{font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;}
    html,body{height:100%;margin:0;background:#ffffff;color:#111}
    .center-wrap{
      min-height:100%;display:flex;align-items:center;justify-content:center;padding:24px;box-sizing:border-box;
    }
    .card{
      text-align:center;max-width:520px;width:100%;padding:36px;border-radius:12px;box-shadow:0 6px 24px rgba(17,17,17,0.06);
      background:transparent;
    }
    .title{font-size:22px;font-weight:600;margin:18px 0 8px}
    .subtitle{color:#555;font-size:14px;margin:0 0 20px}
    .clock{
      width:180px;height:180px;margin:0 auto;display:block;
    }
    @media (max-width:420px){
      .clock{width:140px;height:140px}
      .title{font-size:18px}
    }
  </style>

  
  <div class="center-wrap">
    <div class="card" role="main">
      <!-- Inline SVG clock used as the "time restriction" image centered on the page -->
      <svg class="clock" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <defs>
          <linearGradient id="g" x1="0" x2="1">
            <stop offset="0" stop-color="#0ea5e9"/>
            <stop offset="1" stop-color="#6366f1"/>
          </linearGradient>
        </defs>
        <circle cx="100" cy="100" r="90" fill="none" stroke="#e6eefb" stroke-width="20" />
        <circle cx="100" cy="100" r="70" fill="url(#g)" opacity="0.12" />
        <circle cx="100" cy="100" r="70" fill="#fff" />
        <circle cx="100" cy="100" r="2" fill="#111" />
        <!-- hour hand -->
        <rect x="98.5" y="55" width="3" height="45" rx="2" transform="rotate(60 100 100)" fill="#111" />
        <!-- minute hand -->
        <rect x="98.5" y="40" width="3" height="60" rx="2" transform="rotate(150 100 100)" fill="#111" opacity="0.9" />
        <!-- ticks around -->
        <g stroke="#111" stroke-width="2" stroke-linecap="round" opacity="0.8">
          <!-- simple 12 ticks -->
          <line x1="100" y1="20" x2="100" y2="30" />
          <line x1="100" y1="180" x2="100" y2="170" />
          <line x1="20" y1="100" x2="30" y2="100" />
          <line x1="180" y1="100" x2="170" y2="100" />
          <line x1="139.9" y1="30.1" x2="132.1" y2="38" />
          <line x1="60.1" y1="169.9" x2="67.9" y2="162" />
          <line x1="139.9" y1="169.9" x2="132.1" y2="162" />
          <line x1="60.1" y1="30.1" x2="67.9" y2="38" />
          <line x1="170" y1="60" x2="162" y2="67.9" />
          <line x1="30" y1="140" x2="37.9" y2="132.1" />
          <line x1="170" y1="140" x2="162" y2="132.1" />
          <line x1="30" y1="60" x2="37.9" y2="67.9" />
        </g>
      </svg>

      <h1 class="title">Time Restriction</h1>
      <p class="subtitle">Access is limited — this page shows a time restriction illustration centered on a white background.</p>
    </div>
  </div>
<!-- </body> -->

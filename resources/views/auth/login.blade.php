<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="OSHXONA TIZIMI, ​Taomlar ro&amp;apos;yxati">
    <meta name="description" content="">
    <title>UZ-TH | Oshxona tizimi</title>
    <link rel="stylesheet" href="//capp.nicepage.com/bc531a3a3561afb1db27d262d58cd79625bd6cbb/nicepage.css"
          media="screen">
    <link id="u-page-google-font" rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Lobster:400|ADLaM+Display:400">
    <link id="u-theme-google-font" rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    <link rel="stylesheet" href="{{asset('css/app1.css')}}">
    <link rel="stylesheet" href="{{asset('css/nicepage-site.css')}}" media="screen">
    <script class="u-script" type="text/javascript" src="//capp.nicepage.com/assets/jquery-3.5.1.min.js"
            defer=""></script>
    <script class="u-script" type="text/javascript"
            src="//capp.nicepage.com/bc531a3a3561afb1db27d262d58cd79625bd6cbb/nicepage.js" defer=""></script>
    <meta name="generator" content="Nicepage 6.3.1, nicepage.com">
    <meta name="theme-color" content="#478ac9">
    <meta property="og:title" content="Главная">
    <meta property="og:description" content="">
    <meta property="og:type" content="website">
</head>
<body data-path-to-root="/" data-include-products="false" class="u-body u-xl-mode" data-lang="ru">
<header class="u-clearfix u-header u-header" id="sec-59e0">
    <div class="u-clearfix u-sheet u-sheet-1">
        <h1 class="u-custom-font u-text u-text-palette-1-base u-text-1">OSHXONA TIZIMI</h1>
    </div>
</header>
<section class="u-clearfix u-section-1" id="carousel_4783">
    <div class="u-clearfix u-sheet u-sheet-1">
        <div class="custom-expanded data-layout-selected u-align-left u-clearfix u-layout-wrap u-layout-wrap-1">
            <div class="u-layout">
                <div class="u-layout-row">
                    <div class="u-container-style u-layout-cell u-size-23 u-layout-cell-1">
                        <div class="u-container-layout u-valign-top u-container-layout-1">
                            <img class="u-image u-image-contain u-image-default u-preserve-proportions u-image-1"
                                 src="https://assets.nicepagecdn.com/351a832e/6166696/images/f89f2089-7db1-ea8a-0cbe-a7df200f96e8.jpg"
                                 alt="" data-image-width="2640" data-image-height="2640" style="margin-left: 37px">
                            <form method="POST" action="{{route('login')}}">
                                @csrf
                                <div
                                    class="u-container-align-center u-container-style u-grey-3 u-group u-radius-50 u-shape-round u-group-2">
                                    <input type="email" name="email" id="email" style="border-radius: 20px">
                                </div>
                                <p class="u-text u-text-1">
                                    <a href=""
                                       class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-palette-1-base u-btn-1">Login: </a>
                                </p>
                                <div
                                    class="u-container-align-center u-container-style u-grey-3 u-group u-radius-50 u-shape-round u-group-2">
                                    <input type="password" name="password" id="password" style="border-radius: 20px">
                                </div>
                                <p class="u-text u-text-2">
                                    <a href=""
                                       class="u-active-none u-border-none u-btn u-button-link u-button-style u-hover-none u-none u-text-palette-1-base u-btn-2">Parol: </a>
                                </p>
                                <div class="u-palette-1-base u-radius u-shape u-shape-round u-shape-1"
                                     style="text-align: center">
                                    <button type="submit"
                                            style="padding-top: 4px;font-size: 20px;background-color: #478ac9; border: none">
                                        Kirish
                                    </button>
                                </div>
                            </form>
                            <img class="custom-expanded u-image u-image-contain u-image-default u-image-2"
                                 src="https://assets.nicepagecdn.com/351a832e/6166696/images/pngwing.com.png" alt=""
                                 data-image-width="558" data-image-height="480">
                        </div>
                    </div>
                    <div class="u-container-style u-layout-cell u-size-37 u-layout-cell-2">
                        <div class="u-container-layout u-container-layout-4">
                            <h1 class="u-align-center u-custom-font u-font-lobster u-text u-text-palette-1-base u-text-3">
                                Taomlar ro'yxati</h1>
                            <p class="u-text u-text-default u-text-4">
                                <span style="font-weight: 700; font-size: 1.25rem;">DUSHANBA&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span>
                                <br>
                                <span style="font-style: italic;">1-taom nomi</span>
                                <br>
                                <span style="font-weight: 700;">{{$days[0]['meals'][0]['meal']['name'] ?? '-'}}</span>
                                <br>2-taom nomi<br>
                                <span style="font-weight: 700;">{{$days[0]['meals'][1]['meal']['name'] ?? '-'}}</span>
                                <br>
                                <span style="font-weight: 700;">
                      <br>
                      <br>
                    </span>
                                <br>
                            </p>
                            <p class="u-text u-text-default u-text-5">
                                <span style="font-weight: 700; font-size: 1.25rem;">CHORSHANBA&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span>
                                <br>
                                <span style="font-style: italic;">1-taom nomi</span>
                                <br>
                                <span style="font-weight: 700;">{{$days[2]['meals'][0]['meal']['name'] ?? '-'}}</span>
                                <br>2-taom nomi<br>
                                <span style="font-weight: 700;">{{$days[2]['meals'][1]['meal']['name'] ?? '-'}}</span>
                                <br>
                                <span style="font-weight: 700;">
                      <br>
                      <br>
                    </span>
                                <br>
                            </p>
                            <p class="u-text u-text-default u-text-6">
                                <span style="font-weight: 700; font-size: 1.25rem;">JUMA&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span>
                                <br>
                                <span style="font-style: italic;">1-taom nomi</span>
                                <br>
                                <span style="font-weight: 700;">{{$days[4]['meals'][0]['meal']['name'] ?? '-'}}</span>
                                <br>2-taom nomi<br>
                                <span style="font-weight: 700;">{{$days[4]['meals'][1]['meal']['name'] ?? '-'}}</span>
                                <br>
                                <span style="font-weight: 700;">
                      <br>
                      <br>
                    </span>
                                <br>
                            </p>
                            <p class="u-align-center u-text u-text-7">
                    <span style="font-weight: 700; font-size: 1.25rem;">
                      <span class="u-text-palette-2-base">&nbsp; &nbsp;&nbsp;<br>&nbsp; &nbsp; YAKSHANBA
                      </span>&nbsp; &nbsp;&nbsp;
                    </span>
                                <br>
                                <span style="font-style: italic;">1-taom nomi</span>
                                <br>
                                <span style="font-weight: 700;">{{$days[6]['meals'][0]['meal']['name'] ?? '-'}}</span>
                                <br>2-taom nomi<br>
                                <span style="font-weight: 700;">{{$days[6]['meals'][1]['meal']['name'] ?? '-'}}</span>
                                <br>
                                <span style="font-weight: 700;">
                      <br>
                      <br>
                    </span>
                                <br>
                            </p>
                            <img class="u-image u-image-contain u-image-default u-image-3"
                                 src="https://assets.nicepagecdn.com/351a832e/6166696/images/sup.png" alt=""
                                 data-image-width="500" data-image-height="384">
                            <p class="u-text u-text-default u-text-8">
                                <span style="font-weight: 700; font-size: 1.25rem;">SESHANBA&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</span>
                                <br>
                                <span style="font-style: italic;">1-taom nomi</span>
                                <br>
                                <span style="font-weight: 700;">{{$days[1]['meals'][0]['meal']['name'] ?? '-'}}</span>
                                <br>2-taom nomi<br>
                                <span style="font-weight: 700;">{{$days[1]['meals'][1]['meal']['name'] ?? '-'}}</span>
                                <br>
                                <span style="font-weight: 700;">
                      <br>
                      <br>
                    </span>
                                <br>
                            </p>
                            <p class="u-text u-text-default u-text-9">
                                <span style="font-weight: 700; font-size: 1.25rem;">PAYSHANBA&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span>
                                <br>
                                <span style="font-style: italic;">1-taom nomi</span>
                                <br>
                                <span style="font-weight: 700;">{{$days[3]['meals'][0]['meal']['name'] ?? '-'}}</span>
                                <br>2-taom nomi<br>
                                <span style="font-weight: 700;">{{$days[3]['meals'][1]['meal']['name'] ?? '-'}}</span>
                                <br>
                                <span style="font-weight: 700;">
                      <br>
                      <br>
                    </span>
                                <br>
                            </p>
                            <p class="u-text u-text-default u-text-10">
                                <span style="font-weight: 700; font-size: 1.25rem;">SHANBA&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span><br>
                                <span style="font-style: italic;">1-taom nomi</span>
                                <br>
                                <span style="font-weight: 700;">{{$days[5]['meals'][0]['meal']['name'] ?? '-'}}</span>
                                <br>2-taom nomi<br>
                                <span style="font-weight: 700;">{{$days[5]['meals'][1]['meal']['name'] ?? '-'}}</span>
                                <br>
                                <span style="font-weight: 700;">
                      <br>
                      <br>
                    </span>
                                <br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>.u-disable-duration * {
        transition-duration: 0s !important;
    }</style>
</body>

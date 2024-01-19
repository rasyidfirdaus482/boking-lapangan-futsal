# Aplikasi Boking Lapangan Futsal
## _dibuat dengan beberapa tools_




![Xampp](https://img.shields.io/badge/Xampp-F37623?style=for-the-badge&logo=xampp&logoColor=white)
[![Visual Studio](https://badgen.net/badge/icon/visualstudio?icon=visualstudio&label)](https://visualstudio.microsoft.com)

![Bootsrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![css3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
[![JavaScript](https://img.shields.io/badge/--F7DF1E?logo=javascript&logoColor=000)](https://www.javascript.com/) 

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

Aplikasi ini menggunakan bahasa pemrograman PHP dan Mysql sebagai basis data, layout menggunakan CSS murni dan style lainya menggunakan BOOTSRAP . Aplikasi ini memiliki dua role yaitu admin dan user

## Features

- Import a HTML file and watch it magically convert to Markdown
- Drag and drop images (requires your Dropbox account be linked)
- Import and save files from GitHub, Dropbox, Google Drive and One Drive
- Drag and drop markdown and HTML files into Dillinger
- Export documents as Markdown, HTML and PDF

Markdown is a lightweight markup language based on the formatting conventions
that people naturally use in email.
As [John Gruber] writes on the [Markdown site][df1]

> The overriding design goal for Markdown's
> formatting syntax is to make it as readable
> as possible. The idea is that a
> Markdown-formatted document should be
> publishable as-is, as plain text, without
> looking like it's been marked up with tags
> or formatting instructions.

This text you see here is *actually- written in Markdown! To get a feel
for Markdown's syntax, type some text into the left window and
watch the results in the right.

## Tech

Dillinger uses a number of open source projects to work properly:

- [AngularJS] - HTML enhanced for web apps!
- [Ace Editor] - awesome web-based text editor
- [markdown-it] - Markdown parser done right. Fast and easy to extend.
- [Twitter Bootstrap] - great UI boilerplate for modern web apps
- [node.js] - evented I/O for the backend
- [Express] - fast node.js network app framework [@tjholowaychuk]
- [Gulp] - the streaming build system
- [Breakdance](https://breakdance.github.io/breakdance/) - HTML
to Markdown converter
- [jQuery] - duh

And of course Dillinger itself is open source with a [public repository][dill]
 on GitHub.

## Installation

aplikasi ini menggunakan [php](https://www.php.net/releases/8.0/en.php) Version 8.2.12 .

clone repository dengan terminal.

```sh
git clone https://github.com/rasyidfirdaus482/boking-lapangan-futsal.git
```

buat database dengan nama booking

- [x] #739
- [ ] https://github.com/octo-org/octo-repo/issues/740
- [ ] Add delight to the experience when all tasks are complete :tada:


## Struktur File



```bash
├───css
├───images
├───includes
├───js
│   └───sweetalert2-11.10.1
│       └───package
│           ├───dist
│           └───src
│               ├───instanceMethods
│               ├───scss
│               ├───staticMethods
│               └───utils
│                   └───dom
│                       └───renderers
├───modul
├───uploads
│   └───bukti_pembayaran
└───vendor
    ├───composer
    ├───setasign
    │   └───fpdf
    │       ├───doc
    │       ├───font
    │       ├───makefont
    │       └───tutorial
    └───tecnickcom
        └───tcpdf
            ├───config
            ├───examples
            │   ├───barcodes
            │   ├───config
            │   ├───data
            │   │   └───cert
            │   ├───images
            │   └───lang
            ├───fonts
            │   ├───ae_fonts_2.0
            │   ├───dejavu-fonts-ttf-2.33
            │   ├───dejavu-fonts-ttf-2.34
            │   ├───freefont-20100919
            │   └───freefont-20120503
            ├───include
            │   └───barcodes
            └───tools
PS C:\xampp\htdocs\boking_futsal2> tree /F
Folder PATH listing
Volume serial number is 8ADE-2832
C:.
│   booking.sql
│   cancel_booking.php
│   cetak_invoice.php
│   composer.json
│   composer.lock
│   edit_boking.php
│   edit_profil.php
│   halamanadmin.php
│   halamanuser.php
│   index.php
│   invoice_template.php
│   jam.php
│   lapangan_info.php
│   login.php
│   menu.php
│   navbar.php
│   navbarpembayaran.php
│   navbarprofil.php
│   pembayaran.php
│   process_admin_setting.php
│   process_booking.php
│   profiluser.php
│   proses_pembayaran.php
│   proses_upload_bukti.php
│   register.php
│   verifikasi_booking.php
│
├───css
│       login.css
│       lp.css
│       menu.css
│       nav.css
│       profil.css
│       register.css
│       style.css
│
├───images
│       lp.jpg
│       lp1.png
│       walpaperlogin1.jpg
│
├───includes
│       db_connection.php
│       
├───js
│   │   lp.js
│   │   sweetalert2-11.10.1.tgz
│   │
│   └───sweetalert2-11.10.1
│       └───package
│           │   LICENSE
│           │   package.json
│           │   README.md
│           │   sweetalert2.d.ts
│           │   
│           ├───dist
│           │       sweetalert2.all.js
│           │       sweetalert2.all.min.js
│           │       sweetalert2.css
│           │       sweetalert2.js
│           │       sweetalert2.min.css
│           │       sweetalert2.min.js
│           │
│           └───src
│               │   buttons-handlers.js
│               │   constants.js
│               │   globalState.js
│               │   instanceMethods.js
│               │   keydown-handler.js
│               │   popup-click-handler.js
│               │   privateMethods.js
│               │   privateProps.js
│               │   staticMethods.js
│               │   SweetAlert.js
│               │   sweetalert2.js
│               │   sweetalert2.scss
│               │   types.js
│               │   variables.scss
│               │
│               ├───instanceMethods
│               │       close.js
│               │       enable-disable-elements.js
│               │       getInput.js
│               │       hideLoading.js
│               │       update.js
│               │       validation-message.js
│               │       _destroy.js
│               │
│               ├───scss
│               │       _animations.scss
│               │       _body.scss
│               │       _core.scss
│               │       _icons.scss
│               │       _mixins.scss
│               │       _theming.scss
│               │       _toasts-animations.scss
│               │       _toasts-body.scss
│               │       _toasts.scss
│               │
│               ├───staticMethods
│               │       argsToParams.js
│               │       bindClickHandler.js
│               │       dom.js
│               │       fire.js
│               │       mixin.js
│               │       showLoading.js
│               │       timer.js
│               │
│               └───utils
│                   │   aria.js
│                   │   classes.js
│                   │   defaultInputValidators.js
│                   │   DismissReason.js
│                   │   getTemplateParams.js
│                   │   iosFix.js
│                   │   isNodeEnv.js
│                   │   openPopup.js
│                   │   params.js
│                   │   scrollbar.js
│                   │   setParameters.js
│                   │   Timer.js
│                   │   utils.js
│                   │
│                   └───dom
│                       │   animationEndEvent.js
│                       │   domUtils.js
│                       │   getters.js
│                       │   index.js
│                       │   init.js
│                       │   inputUtils.js
│                       │   parseHtmlToContainer.js
│                       │
│                       └───renderers
│                               render.js
│                               renderActions.js
│                               renderCloseButton.js
│                               renderContainer.js
│                               renderContent.js
│                               renderFooter.js
│                               renderIcon.js
│                               renderImage.js
│                               renderInput.js
│                               renderPopup.js
│                               renderProgressSteps.js
│                               renderTitle.js
│
├───modul
│       admin_setting.php
│       dataadmin.php
│       datauser.php
│       tambahadmin.php
│
├───uploads
│   │   65a257f87f74a.png
│   │   65a258e996542.png
│   │   65a25c3fd11fd.png
│   │   65a25dd969254.jpg
│   │   65a2609337223.jpg
│   │   65a7e6e6250af.png
│   │   65aa4e8533e75.png
│   │
│   └───bukti_pembayaran
│           1 arif .jpg
│           1.PNG
│           2.PNG
│           3.png
│           4.PNG
│           5.PNG
│           6.PNG
│           8.PNG
│           Cuplikan layar 2023-12-17 221408.png
│           ec043d97d3571324d54b6bf5d50557bf.jpg
│           fbd70107cc3579e4f028dfaeda671d95.jpg
│           Screenshot_2024-01-11-12-44-41-850_com.axis.net.jpg
│           Screenshot_2024-01-12-12-35-59-495_id.dana.jpg
│           ss instance login.png
│
└───vendor
    │   autoload.php
    │
    ├───composer
    │       autoload_classmap.php
    │       autoload_namespaces.php
    │       autoload_psr4.php
    │       autoload_real.php
    │       autoload_static.php
    │       ClassLoader.php
    │       installed.json
    │       installed.php
    │       InstalledVersions.php
    │       LICENSE
    │       platform_check.php
    │       
    ├───setasign
    │   └───fpdf
    │       │   changelog.htm
    │       │   composer.json
    │       │   FAQ.htm
    │       │   fpdf.css
    │       │   fpdf.php
    │       │   install.txt
    │       │   license.txt
    │       │   README.md
    │       │
    │       ├───doc
    │       │       acceptpagebreak.htm
    │       │       addfont.htm
    │       │       addlink.htm
    │       │       addpage.htm
    │       │       aliasnbpages.htm
    │       │       cell.htm
    │       │       close.htm
    │       │       error.htm
    │       │       footer.htm
    │       │       getpageheight.htm
    │       │       getpagewidth.htm
    │       │       getstringwidth.htm
    │       │       getx.htm
    │       │       gety.htm
    │       │       header.htm
    │       │       image.htm
    │       │       index.htm
    │       │       line.htm
    │       │       link.htm
    │       │       ln.htm
    │       │       multicell.htm
    │       │       output.htm
    │       │       pageno.htm
    │       │       rect.htm
    │       │       setauthor.htm
    │       │       setautopagebreak.htm
    │       │       setcompression.htm
    │       │       setcreator.htm
    │       │       setdisplaymode.htm
    │       │       setdrawcolor.htm
    │       │       setfillcolor.htm
    │       │       setfont.htm
    │       │       setfontsize.htm
    │       │       setkeywords.htm
    │       │       setleftmargin.htm
    │       │       setlinewidth.htm
    │       │       setlink.htm
    │       │       setmargins.htm
    │       │       setrightmargin.htm
    │       │       setsubject.htm
    │       │       settextcolor.htm
    │       │       settitle.htm
    │       │       settopmargin.htm
    │       │       setx.htm
    │       │       setxy.htm
    │       │       sety.htm
    │       │       text.htm
    │       │       write.htm
    │       │       __construct.htm
    │       │
    │       ├───font
    │       │       courier.php
    │       │       courierb.php
    │       │       courierbi.php
    │       │       courieri.php
    │       │       helvetica.php
    │       │       helveticab.php
    │       │       helveticabi.php
    │       │       helveticai.php
    │       │       symbol.php
    │       │       times.php
    │       │       timesb.php
    │       │       timesbi.php
    │       │       timesi.php
    │       │       zapfdingbats.php
    │       │
    │       ├───makefont
    │       │       cp1250.map
    │       │       cp1251.map
    │       │       cp1252.map
    │       │       cp1253.map
    │       │       cp1254.map
    │       │       cp1255.map
    │       │       cp1257.map
    │       │       cp1258.map
    │       │       cp874.map
    │       │       iso-8859-1.map
    │       │       iso-8859-11.map
    │       │       iso-8859-15.map
    │       │       iso-8859-16.map
    │       │       iso-8859-2.map
    │       │       iso-8859-4.map
    │       │       iso-8859-5.map
    │       │       iso-8859-7.map
    │       │       iso-8859-9.map
    │       │       koi8-r.map
    │       │       koi8-u.map
    │       │       makefont.php
    │       │       ttfparser.php
    │       │
    │       └───tutorial
    │               20k_c1.txt
    │               20k_c2.txt
    │               CevicheOne-Regular-Licence.txt
    │               CevicheOne-Regular.php
    │               CevicheOne-Regular.ttf
    │               CevicheOne-Regular.z
    │               countries.txt
    │               index.htm
    │               logo.png
    │               makefont.php
    │               tuto1.htm
    │               tuto1.php
    │               tuto2.htm
    │               tuto2.php
    │               tuto3.htm
    │               tuto3.php
    │               tuto4.htm
    │               tuto4.php
    │               tuto5.htm
    │               tuto5.php
    │               tuto6.htm
    │               tuto6.php
    │               tuto7.htm
    │               tuto7.php
    │
    └───tecnickcom
        └───tcpdf
            │   CHANGELOG.TXT
            │   composer.json
            │   LICENSE.TXT
            │   README.md
            │   tcpdf.php
            │   tcpdf_autoconfig.php
            │   tcpdf_barcodes_1d.php
            │   tcpdf_barcodes_2d.php
            │   tcpdf_import.php
            │   tcpdf_parser.php
            │   VERSION
            │
            ├───config
            │       tcpdf_config.php
            │
            ├───examples
            │   │   example_001.php
            │   │   example_002.php
            │   │   example_003.php
            │   │   example_004.php
            │   │   example_005.php
            │   │   example_006.php
            │   │   example_007.php
            │   │   example_008.php
            │   │   example_009.php
            │   │   example_010.php
            │   │   example_011.php
            │   │   example_012.pdf
            │   │   example_012.php
            │   │   example_013.php
            │   │   example_014.php
            │   │   example_015.php
            │   │   example_016.php
            │   │   example_017.php
            │   │   example_018.php
            │   │   example_019.php
            │   │   example_020.php
            │   │   example_021.php
            │   │   example_022.php
            │   │   example_023.php
            │   │   example_024.php
            │   │   example_025.php
            │   │   example_026.php
            │   │   example_027.php
            │   │   example_028.php
            │   │   example_029.php
            │   │   example_030.php
            │   │   example_031.php
            │   │   example_032.php
            │   │   example_033.php
            │   │   example_034.php
            │   │   example_035.php
            │   │   example_036.php
            │   │   example_037.php
            │   │   example_038.php
            │   │   example_039.php
            │   │   example_040.php
            │   │   example_041.php
            │   │   example_042.php
            │   │   example_043.php
            │   │   example_044.php
            │   │   example_045.php
            │   │   example_046.php
            │   │   example_047.php
            │   │   example_048.php
            │   │   example_049.php
            │   │   example_050.php
            │   │   example_051.php
            │   │   example_052.php
            │   │   example_053.php
            │   │   example_054.php
            │   │   example_055.php
            │   │   example_056.php
            │   │   example_057.php
            │   │   example_058.php
            │   │   example_059.php
            │   │   example_060.php
            │   │   example_061.php
            │   │   example_062.php
            │   │   example_063.php
            │   │   example_064.php
            │   │   example_065.php
            │   │   example_066.php
            │   │   example_067.php
            │   │   index.php
            │   │   tcpdf_include.php
            │   │
            │   ├───barcodes
            │   │       example_1d_html.php
            │   │       example_1d_png.php
            │   │       example_1d_svg.php
            │   │       example_1d_svgi.php
            │   │       example_2d_datamatrix_html.php
            │   │       example_2d_datamatrix_png.php
            │   │       example_2d_datamatrix_svg.php
            │   │       example_2d_datamatrix_svgi.php
            │   │       example_2d_pdf417_html.php
            │   │       example_2d_pdf417_png.php
            │   │       example_2d_pdf417_svg.php
            │   │       example_2d_pdf417_svgi.php
            │   │       example_2d_qrcode_html.php
            │   │       example_2d_qrcode_png.php
            │   │       example_2d_qrcode_svg.php
            │   │       example_2d_qrcode_svgi.php
            │   │       tcpdf_barcodes_1d_include.php
            │   │       tcpdf_barcodes_2d_include.php
            │   │
            │   ├───config
            │   │       tcpdf_config_alt.php
            │   │
            │   ├───data
            │   │   │   chapter_demo_1.txt
            │   │   │   chapter_demo_2.txt
            │   │   │   table_data_demo.txt
            │   │   │   utf8test.txt
            │   │   │
            │   │   └───cert
            │   │           tcpdf.crt
            │   │           tcpdf.fdf
            │   │           tcpdf.p12
            │   │
            │   ├───images
            │   │       alpha.png
            │   │       image_demo.jpg
            │   │       image_with_alpha.png
            │   │       img.png
            │   │       logo_example.gif
            │   │       logo_example.jpg
            │   │       logo_example.png
            │   │       tcpdf_box.ai
            │   │       tcpdf_box.svg
            │   │       tcpdf_cell.png
            │   │       tcpdf_logo.jpg
            │   │       tcpdf_signature.png
            │   │       testsvg.svg
            │   │       tux.svg
            │   │       _blank.png
            │   │
            │   └───lang
            │           afr.php
            │           ara.php
            │           aze.php
            │           bel.php
            │           bra.php
            │           bul.php
            │           cat.php
            │           ces.php
            │           chi.php
            │           cym.php
            │           dan.php
            │           eng.php
            │           est.php
            │           eus.php
            │           far.php
            │           fra.php
            │           ger.php
            │           gle.php
            │           glg.php
            │           hat.php
            │           heb.php
            │           hrv.php
            │           hun.php
            │           hye.php
            │           ind.php
            │           ita.php
            │           jpn.php
            │           kat.php
            │           kor.php
            │           mkd.php
            │           mlt.php
            │           msa.php
            │           nld.php
            │           nob.php
            │           pol.php
            │           por.php
            │           ron.php
            │           rus.php
            │           slv.php
            │           spa.php
            │           sqi.php
            │           srp.php
            │           swa.php
            │           swe.php
            │           ukr.php
            │           urd.php
            │           yid.php
            │           zho.php
            │
            ├───fonts
            │   │   aealarabiya.ctg.z
            │   │   aealarabiya.php
            │   │   aealarabiya.z
            │   │   aefurat.ctg.z
            │   │   aefurat.php
            │   │   aefurat.z
            │   │   cid0cs.php
            │   │   cid0ct.php
            │   │   cid0jp.php
            │   │   cid0kr.php
            │   │   courier.php
            │   │   courierb.php
            │   │   courierbi.php
            │   │   courieri.php
            │   │   dejavusans.ctg.z
            │   │   dejavusans.php
            │   │   dejavusans.z
            │   │   dejavusansb.ctg.z
            │   │   dejavusansb.php
            │   │   dejavusansb.z
            │   │   dejavusansbi.ctg.z
            │   │   dejavusansbi.php
            │   │   dejavusansbi.z
            │   │   dejavusanscondensed.ctg.z
            │   │   dejavusanscondensed.php
            │   │   dejavusanscondensed.z
            │   │   dejavusanscondensedb.ctg.z
            │   │   dejavusanscondensedb.php
            │   │   dejavusanscondensedb.z
            │   │   dejavusanscondensedbi.ctg.z
            │   │   dejavusanscondensedbi.php
            │   │   dejavusanscondensedbi.z
            │   │   dejavusanscondensedi.ctg.z
            │   │   dejavusanscondensedi.php
            │   │   dejavusanscondensedi.z
            │   │   dejavusansextralight.ctg.z
            │   │   dejavusansextralight.php
            │   │   dejavusansextralight.z
            │   │   dejavusansi.ctg.z
            │   │   dejavusansi.php
            │   │   dejavusansi.z
            │   │   dejavusansmono.ctg.z
            │   │   dejavusansmono.php
            │   │   dejavusansmono.z
            │   │   dejavusansmonob.ctg.z
            │   │   dejavusansmonob.php
            │   │   dejavusansmonob.z
            │   │   dejavusansmonobi.ctg.z
            │   │   dejavusansmonobi.php
            │   │   dejavusansmonobi.z
            │   │   dejavusansmonoi.ctg.z
            │   │   dejavusansmonoi.php
            │   │   dejavusansmonoi.z
            │   │   dejavuserif.ctg.z
            │   │   dejavuserif.php
            │   │   dejavuserif.z
            │   │   dejavuserifb.ctg.z
            │   │   dejavuserifb.php
            │   │   dejavuserifb.z
            │   │   dejavuserifbi.ctg.z
            │   │   dejavuserifbi.php
            │   │   dejavuserifbi.z
            │   │   dejavuserifcondensed.ctg.z
            │   │   dejavuserifcondensed.php
            │   │   dejavuserifcondensed.z
            │   │   dejavuserifcondensedb.ctg.z
            │   │   dejavuserifcondensedb.php
            │   │   dejavuserifcondensedb.z
            │   │   dejavuserifcondensedbi.ctg.z
            │   │   dejavuserifcondensedbi.php
            │   │   dejavuserifcondensedbi.z
            │   │   dejavuserifcondensedi.ctg.z
            │   │   dejavuserifcondensedi.php
            │   │   dejavuserifcondensedi.z
            │   │   dejavuserifi.ctg.z
            │   │   dejavuserifi.php
            │   │   dejavuserifi.z
            │   │   freemono.ctg.z
            │   │   freemono.php
            │   │   freemono.z
            │   │   freemonob.ctg.z
            │   │   freemonob.php
            │   │   freemonob.z
            │   │   freemonobi.ctg.z
            │   │   freemonobi.php
            │   │   freemonobi.z
            │   │   freemonoi.ctg.z
            │   │   freemonoi.php
            │   │   freemonoi.z
            │   │   freesans.ctg.z
            │   │   freesans.php
            │   │   freesans.z
            │   │   freesansb.ctg.z
            │   │   freesansb.php
            │   │   freesansb.z
            │   │   freesansbi.ctg.z
            │   │   freesansbi.php
            │   │   freesansbi.z
            │   │   freesansi.ctg.z
            │   │   freesansi.php
            │   │   freesansi.z
            │   │   freeserif.ctg.z
            │   │   freeserif.php
            │   │   freeserif.z
            │   │   freeserifb.ctg.z
            │   │   freeserifb.php
            │   │   freeserifb.z
            │   │   freeserifbi.ctg.z
            │   │   freeserifbi.php
            │   │   freeserifbi.z
            │   │   freeserifi.ctg.z
            │   │   freeserifi.php
            │   │   freeserifi.z
            │   │   helvetica.php
            │   │   helveticab.php
            │   │   helveticabi.php
            │   │   helveticai.php
            │   │   hysmyeongjostdmedium.php
            │   │   kozgopromedium.php
            │   │   kozminproregular.php
            │   │   msungstdlight.php
            │   │   pdfacourier.php
            │   │   pdfacourier.z
            │   │   pdfacourierb.php
            │   │   pdfacourierb.z
            │   │   pdfacourierbi.php
            │   │   pdfacourierbi.z
            │   │   pdfacourieri.php
            │   │   pdfacourieri.z
            │   │   pdfahelvetica.php
            │   │   pdfahelvetica.z
            │   │   pdfahelveticab.php
            │   │   pdfahelveticab.z
            │   │   pdfahelveticabi.php
            │   │   pdfahelveticabi.z
            │   │   pdfahelveticai.php
            │   │   pdfahelveticai.z
            │   │   pdfasymbol.php
            │   │   pdfasymbol.z
            │   │   pdfatimes.php
            │   │   pdfatimes.z
            │   │   pdfatimesb.php
            │   │   pdfatimesb.z
            │   │   pdfatimesbi.php
            │   │   pdfatimesbi.z
            │   │   pdfatimesi.php
            │   │   pdfatimesi.z
            │   │   pdfazapfdingbats.php
            │   │   pdfazapfdingbats.z
            │   │   stsongstdlight.php
            │   │   symbol.php
            │   │   times.php
            │   │   timesb.php
            │   │   timesbi.php
            │   │   timesi.php
            │   │   uni2cid_ac15.php
            │   │   uni2cid_ag15.php
            │   │   uni2cid_aj16.php
            │   │   uni2cid_ak12.php
            │   │   zapfdingbats.php
            │   │
            │   ├───ae_fonts_2.0
            │   │       ChangeLog
            │   │       COPYING
            │   │       README
            │   │
            │   ├───dejavu-fonts-ttf-2.33
            │   │       AUTHORS
            │   │       BUGS
            │   │       langcover.txt
            │   │       LICENSE
            │   │       NEWS
            │   │       README
            │   │       unicover.txt
            │   │
            │   ├───dejavu-fonts-ttf-2.34
            │   │       AUTHORS
            │   │       BUGS
            │   │       langcover.txt
            │   │       LICENSE
            │   │       NEWS
            │   │       README
            │   │       unicover.txt
            │   │
            │   ├───freefont-20100919
            │   │       AUTHORS
            │   │       ChangeLog
            │   │       COPYING
            │   │       CREDITS
            │   │       INSTALL
            │   │       README
            │   │
            │   └───freefont-20120503
            │           AUTHORS
            │           ChangeLog
            │           COPYING
            │           CREDITS
            │           INSTALL
            │           README
            │           TROUBLESHOOTING
            │           USAGE
            │
            ├───include
            │   │   sRGB.icc
            │   │   tcpdf_colors.php
            │   │   tcpdf_filters.php
            │   │   tcpdf_fonts.php
            │   │   tcpdf_font_data.php
            │   │   tcpdf_images.php
            │   │   tcpdf_static.php
            │   │
            │   └───barcodes
            │           datamatrix.php
            │           pdf417.php
            │           qrcode.php
            │
            └───tools
                    .htaccess
                    convert_fonts_examples.txt
                    tcpdf_addfont.php

          ```

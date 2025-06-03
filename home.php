<?php
$page = 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rivaldo Paath - Home</title>
  <link rel="shortcut icon" href="./assets/images/logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
  <main>
    <aside class="sidebar" data-sidebar>
      <div class="sidebar-info">
        <figure class="avatar-box">
          <img src="./assets/images/my-avatar.png" alt="Rivaldo Paath" width="80">
        </figure>
        <div class="info-content">
          <h1 class="name" title="Rivaldo Paath">Rivaldo Paath</h1>
          <p class="title">Informatics Engineering</p>
        </div>
        <button class="info_more-btn" data-sidebar-btn>
          <span>Show Contacts</span>
          <ion-icon name="chevron-down"></ion-icon>
        </button>
      </div>
      <div class="sidebar-info_more">
        <div class="separator"></div>
        <ul class="contacts-list">
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="mail-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title">Email</p>
              <a href="mailto:jonathanpaath@gmail.com" class="contact-link">jonathanpaath@gmail.com</a>
            </div>
          </li>
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="phone-portrait-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title">Phone</p>
              <a href="tel:+6285696299606" class="contact-link">+62 85696299606</a>
            </div>
          </li>
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="calendar-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title">Birthday</p>
              <time datetime="2005-05-13">13 Mei 2005</time>
            </div>
          </li>
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="location-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title">Location</p>
              <address>Manado, Sulawesi Utara, Indonesia</address>
            </div>
          </li>
        </ul>
        <div class="separator"></div>
        <ul class="social-list">
          <li class="social-item">
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>
          <li class="social-item">
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>
          <li class="social-item">
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>
        </ul>
      </div>
    </aside>
    <div class="main-content">
      <nav class="navbar">
        <ul class="navbar-list">
          <li class="navbar-item">
            <a href="home.php" class="navbar-link <?php echo $page === 'home' ? 'active' : ''; ?>">Home</a>
          </li>
          <li class="navbar-item">
            <a href="gallery.php" class="navbar-link <?php echo $page === 'gallery' ? 'active' : ''; ?>">Gallery</a>
          </li>
          <li class="navbar-item">
            <a href="blog.php" class="navbar-link <?php echo $page === 'blog' ? 'active' : ''; ?>">Blog</a>
          </li>
          <li class="navbar-item">
            <a href="contact.php" class="navbar-link <?php echo $page === 'contact' ? 'active' : ''; ?>">Contact</a>
          </li>
        </ul>
      </nav>
      <article class="home active" data-page="home">
        <header>
          <h2 class="h2 article-title">About me</h2>
        </header>
        <section class="about-text">
          <p>
          Halo! Saya Rivaldo Paath, mahasiswa Teknik Informatika yang
          memiliki antusiasme besar dalam dunia teknologi dan pengembangan
          digital. Perjalanan saya di bidang pemrograman dan inovasi
          didorong oleh rasa ingin tahu untuk mengeksplorasi bagaimana
          teknologi dapat memecahkan masalah dunia nyata dan meningkatkan
          pengalaman pengguna. Di luar dunia kode, saya adalah seorang
          pembaca setia, menikmati literatur rohani, komik, hingga novel.
          Bagi saya, membaca bukan sekadar hobi, melainkan pintu menuju
          inspirasi, wawasan baru, dan ide-ide kreatif.
          </p>
          <p>
          Misi saya adalah menciptakan solusi digital yang tidak hanya
          fungsional dan efisien, tetapi juga menarik dan mudah digunakan.
          Baik saat mengembangkan situs web, merancang antarmuka pengguna,
          atau menangani tantangan pemrograman yang kompleks, saya selalu
          berusaha menyisipkan sentuhan kreatif dan personal dalam setiap
          proyek. Tujuan saya adalah mewujudkan visi Anda dengan cara yang
          memikat audiens, mencerminkan identitas unik Anda, dan memberikan
          pengalaman pengguna yang mulus. Dengan kombinasi keahlian teknis
          dan pola pikir kreatif, saya siap mengubah ide menjadi pengalaman
          digital yang berdampak dan ramah pengguna.
          </p>
        </section>
        <section class="service">
        <h3 class="h3 service-title">What I'm Doing</h3>
            <ul class="service-list">
              <li class="service-item">
                <div class="service-icon-box">
                  <img
                    src="./assets/images/icon-dev.svg"
                    alt="design icon"
                    width="40"
                  />
                </div>
                <div class="service-content-box">
                  <h4 class="h4 service-item-title">Belajar Pemrograman</h4>
                  <p class="service-item-text">
                    Mengasah keterampilan coding untuk membangun solusi digital
                    yang inovatif.
                  </p>
                </div>
              </li>
              <li class="service-item">
                <div class="service-icon-box">
                  <img
                    src="./assets/images/icon-design.svg"
                    alt="Web development icon"
                    width="40"
                  />
                </div>
                <div class="service-content-box">
                  <h4 class="h4 service-item-title">Eksplorasi Teknologi</h4>
                  <p class="service-item-text">
                    Menjelajahi tren dan inovasi digital untuk mengembangkan
                    ide-ide kreatif.
                  </p>
                </div>
              </li>
              <li class="service-item">
                <div class="service-icon-box">
                  <img
                    src="./assets/images/icon-app.svg"
                    alt="mobile app icon"
                    width="40"
                  />
                </div>
                <div class="service-content-box">
                  <h4 class="h4 service-item-title">Literatur Rohani</h4>
                  <p class="service-item-text">
                    Membaca buku rohani untuk memperdalam refleksi dan
                    pertumbuhan spiritual.
                  </p>
                </div>
              </li>
              <li class="service-item">
                <div class="service-icon-box">
                  <img
                    src="./assets/images/icon-photo.svg"
                    alt="camera icon"
                    width="40"
                  />
                </div>
                <div class="service-content-box">
                  <h4 class="h4 service-item-title">Menikmati Koleksi Komik</h4>
                  <p class="service-item-text">
                    Menyisihkan waktu untuk menikmati komik sebagai sumber ide
                    kreatif dan hiburan.
                  </p>
                </div>
              </li>
            </ul>
          </section>
        </article>
      </div>
    </main>
  <script src="./assets/js/script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
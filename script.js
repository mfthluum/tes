// Animasi elemen saat di-scroll (tidak ada perubahan dari sebelumnya)
const faders = document.querySelectorAll('.fade-in');

const appearOptions = {
  threshold: 0.3,
  rootMargin: "0px 0px -50px 0px"
};

const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
  entries.forEach(entry => {
    if (!entry.isIntersecting) {
      return;
    } else {
      entry.target.classList.add('appear');
      appearOnScroll.unobserve(entry.target);
    }
  });
}, appearOptions);

faders.forEach(fader => {
  appearOnScroll.observe(fader);
});

// Contoh: Efek untuk tombol Daftar Sekarang (jika ingin animasi denyut)
// Bagian ini tidak perlu diaktifkan jika kamu sudah pakai CSS @keyframes untuk pulse
/*
const primaryBtn = document.querySelector('.btn-primary');
if (primaryBtn) {
    primaryBtn.addEventListener('mouseenter', () => {
        primaryBtn.classList.add('animate__pulse');
    });
    primaryBtn.addEventListener('mouseleave', () => {
        primaryBtn.classList.remove('animate__pulse');
    });
}
*/
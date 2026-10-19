// Toggle tema terang/gelap. Pilihan disimpan di localStorage dengan key yang sama dengan
// skrip kecil di <head> (mencegah flash tema salah saat halaman dimuat).

const KEY = "stisla-theme";
const root = document.documentElement;

const ICONS = {
  sun: '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>',
  moon: '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401"/></svg>',
};

function paint(theme) {
  const glyph = theme === "dark" ? ICONS.sun : ICONS.moon;
  document.querySelectorAll("[data-theme-toggle]").forEach((btn) => {
    btn.innerHTML = glyph;
    btn.setAttribute("aria-label", theme === "dark" ? "Ganti ke tema terang" : "Ganti ke tema gelap");
  });
}

function apply(theme) {
  root.dataset.theme = theme;
  try {
    localStorage.setItem(KEY, theme);
  } catch (_) {
    /* localStorage bisa dinonaktifkan — abaikan */
  }
  paint(theme);
}

document.addEventListener("click", (e) => {
  if (!e.target.closest("[data-theme-toggle]")) return;
  apply(root.dataset.theme === "dark" ? "light" : "dark");
});

paint(root.dataset.theme || "light");

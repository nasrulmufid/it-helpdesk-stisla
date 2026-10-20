// Koordinator app shell: tombol hamburger di navbar ([data-stisla-app-shell-toggle]) membuka
// drawer sidebar di layar kecil dan mengecilkan sidebar (rail) di layar besar.
// Diadaptasi dari template dashboard resmi Stisla (Meridian).

const SHELL = "[data-stisla-app-shell]";
const TOGGLE = "[data-stisla-app-shell-toggle]";
const SIDEBAR = ":scope > .sidebar";
const MOBILE = "(max-width: 63.99rem)"; // di bawah breakpoint lg

const isMobile = () => window.matchMedia(MOBILE).matches;
const isCollapsed = (shell) => shell.classList.contains("is-sidebar-collapsed");
const isVisible = (shell) => shell.classList.contains("is-sidebar-visible");

function syncTriggers(shell) {
  const expanded = isMobile() ? isVisible(shell) : !isCollapsed(shell);
  shell.querySelectorAll(TOGGLE).forEach((t) => t.setAttribute("aria-expanded", String(expanded)));
}

function setCollapsed(shell, next) {
  shell.classList.toggle("is-sidebar-collapsed", next);
  shell.querySelector(SIDEBAR)?.toggleAttribute("data-collapsed", next);
  syncTriggers(shell);
}

function setVisible(shell, next) {
  shell.classList.toggle("is-sidebar-visible", next);
  syncTriggers(shell);
}

document.addEventListener("click", (e) => {
  const dismissToast = e.target.closest("[data-toast-dismiss]");
  if (dismissToast) {
    const toast = dismissToast.closest(".toast");
    toast?.classList.add("is-dismissing");
    window.setTimeout(() => toast?.remove(), 160);
    return;
  }

  const trigger = e.target.closest(TOGGLE);
  if (trigger) {
    const shell = trigger.closest(SHELL);
    if (!shell) return;
    if (isMobile()) setVisible(shell, !isVisible(shell));
    else setCollapsed(shell, !isCollapsed(shell));
    return;
  }
  // Klik backdrop (pseudo-element .app-shell::before) jatuh ke shell itu sendiri.
  const openShell = e.target.closest(`${SHELL}.is-sidebar-visible`);
  if (openShell && !e.target.closest(".sidebar")) setVisible(openShell, false);
});

document.addEventListener("keydown", (e) => {
  if (e.key !== "Escape") return;
  document.querySelectorAll(`${SHELL}.is-sidebar-visible`).forEach((shell) => setVisible(shell, false));
});

window.matchMedia(MOBILE).addEventListener("change", (e) => {
  document.querySelectorAll(SHELL).forEach((shell) => {
    if (!e.matches) setVisible(shell, false);
    syncTriggers(shell);
  });
});

document.querySelectorAll(SHELL).forEach(syncTriggers);

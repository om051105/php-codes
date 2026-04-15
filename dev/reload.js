(() => {
  // Auto-reload page when the current PHP file changes on disk.
  // Works with: php -S localhost:8000 -t <folder>

  const isLocalhost =
    location.hostname === "localhost" ||
    location.hostname === "127.0.0.1" ||
    location.hostname === "::1";

  if (!isLocalhost) return;

  const file = location.pathname || "/index.php";
  let lastMtime = null;

  async function poll() {
    try {
      const url = `/dev/reload.php?file=${encodeURIComponent(file)}&_=${Date.now()}`;
      const res = await fetch(url, { cache: "no-store" });
      if (!res.ok) return;
      const data = await res.json();
      if (typeof data.mtime !== "number") return;

      if (lastMtime === null) {
        lastMtime = data.mtime;
        return;
      }

      if (data.mtime !== lastMtime) {
        location.reload();
      }
    } catch {
      // ignore
    }
  }

  setInterval(poll, 800);
  poll();
})();

/** @type {import('tailwindcss').Config} */
export default {
  content: [   "./resources/**/*.blade.php",
    "./resources/**/*.js",],
  theme: {
    extend: {colors: {
      'police-blue': '#1e40af',     // Biru khas polantas
      'tactical-dark': '#111827',   // Hitam charcoal untuk sidebar
      'safety-yellow': '#facc15',   // Kuning untuk aksi utama
      'tactical-red': '#ef4444',     // Merah untuk alert/terlambat
    }},
  },
  plugins: [],
}


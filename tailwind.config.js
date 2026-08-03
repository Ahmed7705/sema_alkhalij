/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './app/Http/Livewire/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        medical: {
          50: '#F0F9F5',
          100: '#E1F3EC',
          200: '#C3E7D9',
          300: '#94D4BD',
          400: '#5FBA9B',
          500: '#3CA96B', // Accent
          600: '#2E8B54',
          700: '#1F6B41',
          800: '#0F4C3A', // Primary
          900: '#0A3428',
          950: '#041B15',
        },
        accent: {
          DEFAULT: '#3CA96B',
          hover: '#32955D',
          light: '#EAF7F0',
        },
        primary: {
          DEFAULT: '#0F4C3A',
          hover: '#0B3A2C',
          dark: '#07271E',
          light: '#1B6A53',
        },
        surface: {
          DEFAULT: '#F6F9F7',
          card: '#FFFFFF',
          muted: '#EEF4F1',
        },
        darktext: '#1B241F',
      },
      fontFamily: {
        sans: ['Tajawal', 'Inter', 'sans-serif'],
        tajawal: ['Tajawal', 'sans-serif'],
        inter: ['Inter', 'sans-serif'],
      },
      boxShadow: {
        'soft': '0 4px 20px -2px rgba(15, 76, 58, 0.06)',
        'card': '0 10px 30px -5px rgba(15, 76, 58, 0.08)',
        'floating': '0 20px 40px -10px rgba(15, 76, 58, 0.15)',
      },
    },
  },
  plugins: [],
}

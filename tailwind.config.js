module.exports = {
  content: [
    './templates/**/*',         // Cible tous les fichiers dans templates, y compris sous-dossiers
    './public/js/**/*',         // Cible tous les fichiers JS dans public/js
    './assets/css/**/*.css',    // Cible tous les fichiers CSS dans assets
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

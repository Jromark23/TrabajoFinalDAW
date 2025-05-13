// Importamos los modulos de GULP 
const { src, dest, watch, parallel } = require('gulp');

// CSS
const sass = require('gulp-sass')(require('sass'));	//Compilar SASS a CSS
const plumber = require('gulp-plumber');			// Maneja errores sin detener el flujo
const autoprefixer = require('autoprefixer');		//Agrega los prefijos de CSS para compatibilidad
const cssnano = require('cssnano');					// minifica el CSS
const postcss = require('gulp-postcss');			// Permite usar autoprefixe y cssnano
const sourcemaps = require('gulp-sourcemaps');		// crea mapas para depurar el CSS

// Imagenes
const cache = require('gulp-cache');				// Mejora el rendimiento de la cache
const imagemin = require('gulp-imagemin');			// Reduce el tamaño sin perder caliudad
const webp = require('gulp-webp');					// convierte imagenes a webp
const avif = require('gulp-avif');					// convierte a avif

// Javascript
const terser = require('gulp-terser-js');			// Minifica los JS 
const concat = require('gulp-concat');				// Concatena varios archivos JS en un solo archivo
const rename = require('gulp-rename');				// Cambia nombre (xej agregar .min a los minificados)

// Webpack
const webpack = require('webpack-stream');			// Permite usar webpack y empacquetar archivos JS 

// Toma las imagenes de SRC/IMG y las optimiza en build
function imagenes() {
	return src(paths.imagenes)
		.pipe(cache(imagemin({ optimizationLevel: 3 })))
		.pipe(dest('public/build/img'))
}

// convierte las imagenes a webp
function versionWebp(done) {
	const opciones = {
		quality: 50
	};
	src('src/img/**/*.{png,jpg}')
		.pipe(webp(opciones))
		.pipe(dest('public/build/img'))
	done();
}

// convierte las imagenes a avif
function versionAvif(done) {
	const opciones = {
		quality: 50
	};
	src('src/img/**/*.{png,jpg}')
		.pipe(avif(opciones))
		.pipe(dest('public/build/img'))
	done();
}

// Incluimos las rutas para procesar los archivos
const paths = {
	scss: 'src/scss/**/*.scss',
	js: 'src/js/**/*.js',
	imagenes: 'src/img/**/*'
}

// Compila SASS 
function css() {
return src(paths.scss)								// Procesa todos los archivos scss 
	.pipe(sourcemaps.init())						// Genera el sourcemap para depurar los archivos originales y no los procesados
	.pipe(sass({ outputStyle: 'expanded' }))		// Evita que el CSS de salida se comprima y se lea
	.pipe( postcss([autoprefixer()]))				// Prefijos para el soporte en distintos navegadores
	.pipe(sourcemaps.write('.'))
	.pipe(dest('public/build/css'));				// destino del procesado
}

function javascript() {							
	return src(paths.js)
		.pipe(webpack({
			mode: 'production',
			entry: './src/js/app.js',
			module: {
				rules: [
					{
						test: /\.css$/i,
						use: ['style-loader', 'css-loader'], //  Usa css-loader para interpretar los archivos CSS y style-loader para inyectarlos como estilos en el DOM.
					}
				]
			},
			watch: true
		}))
		.pipe(sourcemaps.init())			
		/* ya lo hace webpack y se incluye en el layout en lugar del que generabamos nosotros
		.pipe(concat('bundle.js'))  */
		.pipe(terser())						// Minifica el codigo
		.pipe(sourcemaps.write('.'))		
		.pipe(rename({ suffix: '.min' }))	// Añade el .min 
		.pipe(dest('./public/build/js'))	// Lugar de almacenamiento
}


// Funcion ejecutada para observar los cambios. tras cada cambio llama a la funcion asociada
function dev(done) {
	watch(paths.scss, css);
	watch(paths.js, javascript);
	watch(paths.imagenes, imagenes)
	watch(paths.imagenes, versionWebp)
	watch(paths.imagenes, versionAvif)
	done()
}

// Se exporta para llamarlko desde el terminal 
exports.css = css;
exports.js = javascript;
exports.imagenes = imagenes;
exports.versionWebp = versionWebp;
exports.versionAvif = versionAvif;

// Permite que llamemos a todas a la vez.
exports.dev = parallel(css, imagenes, versionWebp, versionAvif, javascript, dev);
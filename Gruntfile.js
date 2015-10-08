module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		sass: {
			dist: {
				options: {
					sourceMap: true,
					includePaths: require('node-bourbon').includePaths,
					outputStyle: "expanded"
				},
				files: {
					'style.css': 'sass/style.scss'
				}
			}
		},
		autoprefixer: {
			global: {
				options: {
					browsers: ['> 1%', 'last 2 versions', 'ff 17', 'opera 12.1', 'ie 8', 'ie 9']
				},
				src: 'style.css'
			}
		},
		watch: {
			css: {
				files: ['sass/*.scss', 'sass/**/*.scss'],
				tasks: ['sass', 'autoprefixer'],
				options: {
					spawn: false,
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-autoprefixer');

	grunt.registerTask('default', ['watch']);

};

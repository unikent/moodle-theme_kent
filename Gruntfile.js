module.exports = function(grunt) {
    require('jit-grunt')(grunt);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        less: {
            development: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: 2,
                    banner: '/*! <%= pkg.description %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
                    plugins: [
                        new (require('less-plugin-autoprefix'))({
                            browsers: ["last 2 versions"]
                        }),
                        new (require('less-plugin-clean-css'))({
                            advanced: true,
                            compatibility: 'ie8'
                        })
                    ]
                },
                files: {
                    "style/theme.css": "style/less/theme.less",
                    "style/future.css": "style/less/future.less",
                    "style/bootstrap.css": "style/less/bootstrap.less"
                }
            }
        },
        watch: {
            styles: {
                files: ['style/less/**/*.less'], // which files to watch
                tasks: ['less'],
                options: {
                    nospawn: true
                }
            }
        }
    });

    grunt.registerTask('default', ['less']);
};

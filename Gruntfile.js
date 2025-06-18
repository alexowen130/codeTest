module.exports = function(grunt) {
    require("load-grunt-tasks")(grunt);

    const node = "node_modules";
    const jsDir = "public/js";
    const css = "public/css";

    // Project configuration.
    grunt.initConfig({
        copy: {
            bootstrap: {
                expand: true,
                cwd: node + "/",
                src: "bootstrap/dist/**",
                dest: jsDir
            },
            jquery: {
                expand: true,
                cwd: node + "/",
                src: "jquery/dist/**",
                dest: jsDir
            },
        },
    });

    // Default task(s).
    grunt.registerTask("default", ["copy"]);
};
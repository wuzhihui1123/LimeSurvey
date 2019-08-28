
const appName = 'adminsidepanel';
const entryPoint = ['./lib/surveysettings.js','./src/'+appName+'main.js', './scss/'+appName+'main.scss'];
const scssDir = 'scss';

module.exports = {
    outputDir: process.env.NODE_ENV === 'production' ? 'build.min/' : 'build/',
    filenameHashing: false,
    runtimeCompiler: true,
    
    configureWebpack: {
        entry: entryPoint,
        output: {
            filename: () => {return 'js/'+appName+'.js'}
        },
        externals: {
            LS: 'LS',
            jquery: 'jQuery',
            pjax: 'Pjax',
        },
    },

    chainWebpack: config => {
    
        if (config.plugins.has("extract-css")) {
            const extractCSSPlugin = config.plugin("extract-css");
            extractCSSPlugin && extractCSSPlugin.tap(() => [
                {
                    filename: scssDir + "/adminsidepanel.css",
                }
            ])
        }

        config.plugins
            .delete("html")
            .delete("prefetch")
            .delete("preload");
        
        config.optimization.delete('splitChunks');
    }
};
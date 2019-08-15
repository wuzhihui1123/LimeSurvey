import common from 'rollup-plugin-commonjs';
import resolve from 'rollup-plugin-node-resolve';
import babel from 'rollup-plugin-babel';
import { terser } from "rollup-plugin-terser";

const output = {
    file: 'build/event-bus.min.js',
    format: 'umd',
    sourcemap: true,
    name: "EventBus"
};
const plugins = [
    babel({exclude: 'node_modules/**'}),
    resolve(),
    common(),
    terser()
];



module.exports = {
    input: 'src/event-bus.js',
    output,
    plugins
  };

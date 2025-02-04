// const defaultTheme = require('tailwindcss/defaultTheme');
// const forms = require('@tailwindcss/forms');

import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
// module.exports = {
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
	],
	prefix: 'tw-',
	theme: {
		extend: {
			fontFamily: {
				sans: ['Figtree', ...defaultTheme.fontFamily.sans],
			},
		},
	},
	plugins: [forms],
};

// const defaultTheme = require('tailwindcss/defaultTheme');
// module.exports = {
// 	content: [
// 		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
// 		'./storage/framework/views/*.php',
// 		'./resources/views/**/*.blade.php',
// 		'./resources/js/**/*.vue',
// 	],
//
// 	theme: {
// 		extend: {
// 			fontFamily: {
// 				sans: ['Figtree', ...defaultTheme.fontFamily.sans],
// 			},
// 		},
// 	},
// 	plugins: [require('@tailwindcss/forms')],
// };

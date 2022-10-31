/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./Modules/Clouddiskprovider/CloudDiskProvider.js":
/*!********************************************************!*\
  !*** ./Modules/Clouddiskprovider/CloudDiskProvider.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": () => (__WEBPACK_DEFAULT_EXPORT__)\n/* harmony export */ });\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, \"prototype\", { writable: false }); return Constructor; }\n\nvar CloudDiskProvider = /*#__PURE__*/function () {\n  function CloudDiskProvider() {\n    _classCallCheck(this, CloudDiskProvider);\n  }\n\n  _createClass(CloudDiskProvider, [{\n    key: \"setObservers\",\n    value: function setObservers() {\n      var _this = this;\n\n      var renameBnt = document.querySelectorAll('.js-rename');\n      var downloadBnt = document.querySelectorAll('.js-download');\n      var deleteBnt = document.querySelectorAll('.js-delete');\n      var form = document.querySelector('.js-uploader');\n      renameBnt.forEach(function (button) {\n        button.addEventListener('click', function () {\n          var item = button.closest('.js-item');\n          var input = item.querySelector('input');\n          var path = item.getAttribute('data-path');\n          var oldName = item.getAttribute('data-name');\n\n          if (!button.classList.contains('active')) {\n            button.textContent = \"\\u0421\\u043E\\u0445\\u0440\\u0430\\u043D\\u0438\\u0442\\u044C\";\n            input.removeAttribute('readonly');\n            input.focus();\n            button.classList.add('active');\n          } else {\n            button.textContent = \"\\u041F\\u0435\\u0440\\u0435\\u0438\\u043C\\u0435\\u043D\\u043E\\u0432\\u0430\\u0442\\u044C\";\n            button.classList.remove('active');\n            input.setAttribute('readonly', 'true');\n            var newName = input.value;\n\n            if (newName !== oldName) {\n              document.querySelector('.disk').innerHTML = \"<div class=\\\"loader\\\"></div>\";\n\n              var page = _this.getCurrentPage();\n\n              var response = _this.xhrRequest({\n                path: path,\n                page: page,\n                newName: newName,\n                oldName: oldName\n              }, \"rename\", 'yandex');\n\n              document.querySelector('.disk').innerHTML = response;\n\n              _this.setObservers();\n            }\n          }\n        });\n      });\n      downloadBnt.forEach(function (button) {\n        button.addEventListener('click', function () {\n          var item = button.closest('.js-item');\n          var path = item.getAttribute('data-path');\n          var name = item.getAttribute('data-name');\n\n          var response = _this.xhrRequest({\n            path: path\n          }, 'download', 'yandex');\n\n          var link = document.createElement('a');\n          link.setAttribute('href', response);\n          link.setAttribute('download', name);\n          link.click();\n        });\n      });\n      deleteBnt.forEach(function (button) {\n        button.addEventListener('click', function () {\n          var item = button.closest('.js-item');\n          var path = item.getAttribute('data-path');\n\n          var page = _this.getCurrentPage();\n\n          var response = _this.xhrRequest({\n            path: path,\n            page: page\n          }, 'delete', 'yandex');\n\n          document.querySelector('.disk').innerHTML = response;\n\n          _this.setObservers();\n        });\n      });\n      form.addEventListener('submit', function (event) {\n        event.preventDefault();\n        var fileInput = document.querySelector('.js-file');\n        var file = fileInput.files[0];\n\n        if (!_this.validateFile(file)) {\n          document.querySelector('.js-res-upload').textContent = \"Ошибка, приложен некорректный файл!\";\n          return false;\n        }\n\n        var formData = new FormData();\n        formData.append('file', fileInput.files[0]);\n        formData.append('action', 'load');\n        formData.append('page', _this.getCurrentPage());\n        formData.append('provider', 'yandex');\n        document.querySelector('.disk').innerHTML = \"<div class=\\\"loader\\\"></div>\";\n\n        var response = _this.xhrRequestFile('load', 'yandex', formData);\n      });\n    }\n  }, {\n    key: \"validateFile\",\n    value: function validateFile(file) {\n      if (file == undefined) return false;\n      if (file.size > 10000000) return false;\n\n      if (file.type == \"application/x-shellscript\" || file.type == \"application/x-ms-dos-executable\") {\n        return false;\n      }\n\n      return true;\n    }\n  }, {\n    key: \"getCurrentPage\",\n    value: function getCurrentPage() {\n      var urlParams = new URLSearchParams(window.location.search);\n      var page = urlParams.get('page');\n      if (page == null) page = 1;\n      return page;\n    }\n  }, {\n    key: \"xhrRequestFile\",\n    value: function xhrRequestFile(action, provider, send) {\n      var url = '/provider/' + provider + '/action/' + action + '?';\n      var xhr = new XMLHttpRequest();\n      var requestURL = new URL('https://provider.ru' + url);\n      xhr.open('POST', requestURL);\n      xhr.send(send);\n      xhr.onreadystatechange = this.callback();\n    }\n  }, {\n    key: \"callback\",\n    value: function callback(x, m) {\n      return function () {\n        if (this.readyState == 4 && this.status == 200) {\n          document.querySelector('.disk').innerHTML = this.response;\n          new CloudDiskProvider().setObservers();\n          document.querySelector('.js-res-upload').textContent = \"Файл успешно загружен!\";\n        }\n      };\n    }\n  }, {\n    key: \"xhrRequest\",\n    value: function xhrRequest(params, action, provider) {\n      var send = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;\n      var url = '/provider/' + provider + '/action/' + action + '?';\n\n      for (var key in params) {\n        url = url + \"&\" + key + \"=\" + params[key];\n      }\n\n      var xhr = new XMLHttpRequest();\n      var requestURL = new URL('https://provider.ru' + url);\n      xhr.open('GET', requestURL, false);\n      xhr.send(send);\n      return xhr.response;\n    }\n  }]);\n\n  return CloudDiskProvider;\n}();\n\n/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CloudDiskProvider);\n\n//# sourceURL=webpack:///./Modules/Clouddiskprovider/CloudDiskProvider.js?");

/***/ }),

/***/ "./storage/js/index.js":
/*!*****************************!*\
  !*** ./storage/js/index.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _scss_styles_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../scss/styles.scss */ \"./storage/scss/styles.scss\");\n/* harmony import */ var _Modules_Clouddiskprovider_clouddiskprovider_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../Modules/Clouddiskprovider/clouddiskprovider.scss */ \"./Modules/Clouddiskprovider/clouddiskprovider.scss\");\n/* harmony import */ var _css_bootstrap_min_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../css/bootstrap.min.css */ \"./storage/css/bootstrap.min.css\");\n/* harmony import */ var _Modules_Clouddiskprovider_CloudDiskProvider__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../Modules/Clouddiskprovider/CloudDiskProvider */ \"./Modules/Clouddiskprovider/CloudDiskProvider.js\");\n\n\n\n\nwindow.addEventListener('load', function () {\n  var disk = new _Modules_Clouddiskprovider_CloudDiskProvider__WEBPACK_IMPORTED_MODULE_3__[\"default\"]();\n  disk.setObservers();\n});\n\n//# sourceURL=webpack:///./storage/js/index.js?");

/***/ }),

/***/ "./Modules/Clouddiskprovider/clouddiskprovider.scss":
/*!**********************************************************!*\
  !*** ./Modules/Clouddiskprovider/clouddiskprovider.scss ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack:///./Modules/Clouddiskprovider/clouddiskprovider.scss?");

/***/ }),

/***/ "./storage/scss/styles.scss":
/*!**********************************!*\
  !*** ./storage/scss/styles.scss ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack:///./storage/scss/styles.scss?");

/***/ }),

/***/ "./storage/css/bootstrap.min.css":
/*!***************************************!*\
  !*** ./storage/css/bootstrap.min.css ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n\n\n//# sourceURL=webpack:///./storage/css/bootstrap.min.css?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./storage/js/index.js");
/******/ 	
/******/ })()
;
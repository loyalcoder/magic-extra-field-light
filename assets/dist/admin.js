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

/***/ "./src/admin/index.js":
/*!****************************!*\
  !*** ./src/admin/index.js ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ \"jquery\");\n/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);\n\njQuery(function ($) {\n  $('#display_type').select2({\n    minimumResultsForSearch: Infinity\n  });\n  $('#selected_taxonomy').select2({}).on('change', function () {\n    var selectedTaxonomy = $(this).val();\n    $.ajax({\n      url: magic_ef_vars.ajax_url,\n      type: 'POST',\n      data: {\n        action: 'magic_ef_get_taxonomy_terms',\n        taxonomy: selectedTaxonomy,\n        nonce: magic_ef_vars.nonce\n      },\n      beforeSend: function beforeSend() {\n        // Show loading spinner before sending request\n        var $termsSelect = $('.magic-ef-term-select');\n        $termsSelect.empty().prop('disabled', true);\n        $('#terms_selection').hide();\n        var $loader = $('<div class=\"magic-ef-loader\">Loading...</div>');\n        $('#taxonomy_options').append($loader);\n      },\n      success: function success(response) {\n        if (response.success) {\n          var $termsSelect = $('.magic-ef-term-select');\n          if (response.data && response.data.length > 0) {\n            response.data.forEach(function (term) {\n              $termsSelect.append(new Option(term.name, term.term_id));\n            });\n          }\n          $('#terms_selection').show();\n        }\n      },\n      complete: function complete() {\n        // Remove loader and re-enable select\n        $('.magic-ef-loader').remove();\n        $('.magic-ef-term-select').prop('disabled', false);\n      }\n    });\n  });\n  $('#selected_products').select2({});\n  $('.magic-ef-product-select').select2({});\n  $('.magic-ef-term-select').select2({});\n  $('.magic-ef-toggle input[type=\"checkbox\"]').on('change', function () {\n    var isActive = $(this).is(':checked');\n    $('.magic-ef-display-options').toggleClass('active', isActive);\n    $('.magic-ef-display-options').css('display', isActive ? 'block' : 'none');\n  });\n  $('#display_type').on('change', function () {\n    var selectedValue = $(this).val();\n    if (selectedValue === 'specific') {\n      $('#specific_products').show();\n      $('#taxonomy_options').hide();\n    } else if (selectedValue === 'taxonomy') {\n      $('#taxonomy_options').show();\n      $('#specific_products').hide();\n    } else if (selectedValue === 'all') {\n      $('#specific_products').hide();\n      $('#taxonomy_options').hide();\n    }\n  });\n  var displayType = $('#display_type').val();\n  if (displayType === 'specific') {\n    $('#specific_products').show();\n    $('#taxonomy_options').hide();\n  } else if (displayType === 'taxonomy') {\n    $('#taxonomy_options').show();\n    $('#specific_products').hide();\n  }\n\n  // show settings popup\n  $('.magic-ef-settings-btn').on('click', function (event) {\n    event.preventDefault();\n    $('.popup').addClass('show');\n    // Show animated SVG preloader\n    var loaderSvg = \"\\n            <div class=\\\"magic-ef-loader\\\">\\n                <svg width=\\\"38\\\" height=\\\"38\\\" viewBox=\\\"0 0 38 38\\\" xmlns=\\\"http://www.w3.org/2000/svg\\\" stroke=\\\"#2271b1\\\">\\n                    <g fill=\\\"none\\\" fill-rule=\\\"evenodd\\\">\\n                        <g transform=\\\"translate(1 1)\\\" stroke-width=\\\"2\\\">\\n                            <circle stroke-opacity=\\\".5\\\" cx=\\\"18\\\" cy=\\\"18\\\" r=\\\"18\\\"/>\\n                            <path d=\\\"M36 18c0-9.94-8.06-18-18-18\\\">\\n                                <animateTransform\\n                                    attributeName=\\\"transform\\\"\\n                                    type=\\\"rotate\\\"\\n                                    from=\\\"0 18 18\\\"\\n                                    to=\\\"360 18 18\\\"\\n                                    dur=\\\"1s\\\"\\n                                    repeatCount=\\\"indefinite\\\"/>\\n                            </path>\\n                        </g>\\n                    </g>\\n                </svg>\\n            </div>\\n        \";\n    $('.magic-ef-form').html(loaderSvg);\n    // Make AJAX request to get form HTML\n    $.ajax({\n      url: magic_ef_vars.ajax_url,\n      type: 'POST',\n      data: {\n        action: 'magic_ef_get_settings_form',\n        nonce: magic_ef_vars.nonce,\n        post_id: $(this).data('id')\n      },\n      success: function success(response) {\n        if (response.success) {\n          $('.magic-ef-form').html(response.data);\n          $('.magic-ef-product-select').select2({\n            minimumInputLength: 1,\n            allowClear: true\n          });\n          $('select[name=\"display_type\"]').select2({});\n          $('select[name=\"selected_taxonomy\"]').select2({});\n          $('select[name=\"selected_terms[]\"]').select2({});\n        } else {\n          $('.magic-ef-form').html('<p class=\"error\">Error loading settings form</p>');\n        }\n      },\n      error: function error() {\n        $('.magic-ef-form').html('<p class=\"error\">Error loading settings form</p>');\n      }\n    });\n    // Remove preloader after form is fully loaded\n  });\n  $('.close').on('click', function () {\n    $('.popup').removeClass('show');\n  });\n  $(window).on('click', function (event) {\n    if ($(event.target).is('.popup')) {\n      $('.popup').removeClass('show');\n    }\n  });\n  // handel save button\n  $(document).on('change', 'input[name=\"is_active\"], select[name=\"display_type\"], select[name=\"selected_products[]\"], select[name=\"selected_taxonomy\"], select[name=\"selected_terms[]\"]', function () {\n    $('#magic-ef-save').prop('disabled', false);\n    $('#magic-ef-edit-elementor').addClass('disabled');\n    $('#magic-ef-edit-elementor').attr('href', 'javascript:void(0)');\n    $('#magic-ef-edit-elementor').attr('target', '');\n    $('.show-response').html('');\n  });\n  $(document).on('change', 'input[name=\"is_active\"]', function () {\n    var isActive = $(this).is(':checked');\n    if (isActive) {\n      $(this).parents('.magic-ef-toggle-wrapper').siblings('.magic-ef-display-options').show();\n    } else {\n      $(this).parents('.magic-ef-toggle-wrapper').siblings('.magic-ef-display-options').hide();\n    }\n  });\n  $(document).on('change', 'select[name=\"display_type\"]', function () {\n    var displayType = $(this).val();\n    if (displayType === 'all') {\n      $(this).parents('.magic-ef-display-options').find('#specific_products, #taxonomy_options').hide();\n    } else if (displayType === 'specific') {\n      $(this).parents('.magic-ef-display-options').find('#specific_products').show();\n      $(this).parents('.magic-ef-display-options').find('#taxonomy_options').hide();\n    } else if (displayType === 'taxonomy') {\n      $(this).parents('.magic-ef-display-options').find('#specific_products').hide();\n      $(this).parents('.magic-ef-display-options').find('#taxonomy_options').show();\n    }\n  });\n  // default display type\n  // Check initial active state and show/hide display options accordingly\n  $(document).on('ajaxComplete', function () {\n    var isActiveInitially = $('.magic-ef-form input[name=\"is_active\"]').is(':checked');\n    if (isActiveInitially) {\n      $('.magic-ef-display-options').show();\n    } else {\n      $('.magic-ef-display-options').hide();\n    }\n  });\n  // call ajax to get selected terms\n  $(document).on('change', 'select[name=\"selected_taxonomy\"]', function () {\n    var selectedTaxonomy = $(this).val();\n    console.log(selectedTaxonomy);\n    $.ajax({\n      url: magic_ef_vars.ajax_url,\n      type: 'POST',\n      data: {\n        action: 'magic_ef_get_taxonomy_terms',\n        taxonomy: selectedTaxonomy,\n        nonce: magic_ef_vars.nonce\n      },\n      success: function success(response) {\n        if (response.success) {\n          $('select[name=\"selected_terms[]\"]').empty().prop('disabled', true);\n          response.data.forEach(function (term) {\n            $('select[name=\"selected_terms[]\"]').append(new Option(term.name, term.term_id));\n          });\n          $('select[name=\"selected_terms[]\"]').prop('disabled', false);\n        }\n      }\n    });\n  });\n  // save settings\n  $(document).on('submit', '.magic-ef-form', function (e) {\n    e.preventDefault();\n    console.log($('.magic-ef-term-select').val());\n    $.ajax({\n      url: magic_ef_vars.ajax_url,\n      type: 'POST',\n      data: {\n        action: 'magic_ef_save_settings',\n        nonce: magic_ef_vars.nonce,\n        post_id: $(this).find('#magic-ef-save').data('post-id'),\n        settings: $(this).serialize()\n      },\n      success: function success(response) {\n        if (response.success) {\n          $('.show-response').html('<div class=\"success\">' + response.data.message + '</div>');\n          $('#magic-ef-edit-elementor').attr('href', response.data.edit_url);\n          $('#magic-ef-edit-elementor').removeClass('disabled');\n          $('#magic-ef-edit-elementor').attr('target', '_blank');\n          $('#magic-ef-save').prop('disabled', true);\n        } else {\n          $('.show-response').html('<div class=\"error\">' + response.message + '</div>');\n        }\n      }\n    });\n  });\n});\n\n//# sourceURL=webpack://magic-extra-field-light/./src/admin/index.js?");

/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ ((module) => {

module.exports = jQuery;

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
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
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
/******/ 	var __webpack_exports__ = __webpack_require__("./src/admin/index.js");
/******/ 	
/******/ })()
;
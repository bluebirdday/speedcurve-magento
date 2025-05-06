/**
 * Copyright © Bluebirdday. All rights reserved.
 */

define([
    'jquery'
], function ($) {
    'use strict';

    /**
     * Initialize Speedcurve page label
     * @param {Object} config - Configuration object
     * @param {string} config.pageLabel - Custom page label to use for LUX tracking
     * @return {void}
     */
    return function (config) {
        /**
         * Add page label to the LUX object
         * @return {void}
         */
        function addPageLabel() {
            window.LUX = window.LUX || {};

            if (config.pageLabel && typeof window.LUX?.addData === 'function') {
                window.LUX.label = config.pageLabel;
            } else {
                console.warn('LUX object not properly initialized. Could not set page label:', config.pageLabel);
            }
        }

        if (window.speedCurveLoaded) {
            addPageLabel();
        } else {
            $(document).on('SpeedcurveLoaded', function() {
                addPageLabel();
            });
        }
    };
});

/**
 * Copyright © Bluebirdday. All rights reserved.
 */

define([
    'jquery',
    'mage/cookies'
], function ($) {
    'use strict';

    /**
     * Initialize Speedcurve RUM tracking
     * @param {Object} config - Configuration object
     * @param {string} config.luxId - Speedcurve LUX ID
     * @param {boolean} config.cookieConsentEnabled - Whether cookie consent is required
     * @param {string} config.cookieName - Name of the cookie to check for consent
     * @param {string} config.cookieValue - Value to check in cookie
     * @param {string} config.consentLogic - Logic to use for consent checking
     * @param {string} config.logicExists - Logic type for existence check
     * @param {string} config.logicContains - Logic type for contains check
     * @param {string} config.logicNotContains - Logic type for not contains check
     * @return {void}
     */
    return function (config) {
        window.speedCurveLoaded = false;

        /**
         * Append Speedcurve scripts to the document body
         * @param {string} luxId - Speedcurve LUX ID
         * @return {void}
         */
        function appendSpeedCurveScripts(luxId) {
            const scriptSetup = document.createElement('script');
            scriptSetup.type = 'text/javascript';
            scriptSetup.text = 'LUX=function(){function n(){return Date.now?Date.now():+new Date}var r,e=n(),t=window.performance||{},a=t.timing||{navigationStart:(null===(r=window.LUX)||void 0===r?void 0:r.ns)||e};function o(){return t.now?(r=t.now(),Math.floor(r)):n()-a.navigationStart;var r}(LUX=window.LUX||{}).ac=[],LUX.addData=function(n,r){return LUX.cmd(["addData",n,r])},LUX.cmd=function(n){return LUX.ac.push(n)},LUX.getDebug=function(){return[[e,0,[]]]},LUX.init=function(){return LUX.cmd(["init"])},LUX.mark=function(){for(var n=[],r=0;r<arguments.length;r++)n[r]=arguments[r];if(t.mark)return t.mark.apply(t,n);var e=n[0],a=n[1]||{};void 0===a.startTime&&(a.startTime=o());LUX.cmd(["mark",e,a])},LUX.markLoadTime=function(){return LUX.cmd(["markLoadTime",o()])},LUX.measure=function(){for(var n=[],r=0;r<arguments.length;r++)n[r]=arguments[r];if(t.measure)return t.measure.apply(t,n);var e,a=n[0],i=n[1],u=n[2];e="object"==typeof i?n[1]:{start:i,end:u};e.duration||e.end||(e.end=o());LUX.cmd(["measure",a,e])},LUX.send=function(){return LUX.cmd(["send"])},LUX.ns=e;var i=LUX;if(window.LUX_ae=[],window.addEventListener("error",(function(n){window.LUX_ae.push(n)})),window.LUX_al=[],"function"==typeof PerformanceObserver&&"function"==typeof PerformanceLongTaskTiming){var u=new PerformanceObserver((function(n){for(var r=n.getEntries(),e=0;e<r.length;e++)window.LUX_al.push(r[e])}));try{u.observe({type:"longtask"})}catch(n){}}return i}();';

            const scriptExternal = document.createElement('script');
            scriptExternal.src = `https://cdn.speedcurve.com/js/lux.js?id=${luxId}`;
            scriptExternal.async = true;
            scriptExternal.defer = true;
            scriptExternal.crossOrigin = 'anonymous';

            scriptExternal.onload = function() {
                $(document).trigger('SpeedcurveLoaded');
                window.speedCurveLoaded = true;
            };
            scriptExternal.onerror = () => {
                console.error('Failed to load Speedcurve external script.');
            };

            document.body.appendChild(scriptSetup);
            document.body.appendChild(scriptExternal);
        }

        /**
         * Check if user has provided consent based on configuration
         * @param {Object} config - Configuration object
         * @param {boolean} config.cookieConsentEnabled - Whether cookie consent is required
         * @param {string} config.cookieName - Name of the cookie to check for consent
         * @param {string} config.cookieValue - Value to check in cookie
         * @param {string} config.consentLogic - Logic to use for consent checking
         * @return {boolean} Whether consent has been provided
         */
        function hasConsent(config) {
            if (!config.cookieConsentEnabled || !config.cookieName) {
                return true;
            }

            const cookie = $.mage.cookies.get(config.cookieName);

            if (config.consentLogic === config.logicExists) {
                return cookie !== null && cookie !== undefined;
            }

            if (!cookie) {
                return false;
            }

            const requiredValue = config.cookieValue || '';
            const containsValue = cookie.includes(requiredValue);

            if (config.consentLogic === config.logicContains) {
                return requiredValue === '' ? true : containsValue;
            }

            if (config.consentLogic === config.logicNotContains) {
                return requiredValue === '' ? false : !containsValue;
            }

            return false;
        }

        if (hasConsent(config)) {
            if (config.luxId) {
                appendSpeedCurveScripts(config.luxId);
            }
        } else {
            console.warn('Speedcurve RUM not loaded due to missing cookie consent.');
        }
    };
});

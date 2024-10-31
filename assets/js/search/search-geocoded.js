/**
 * form-listings-search
 *
 * @since
 * @author     Alfio Piccione <alfio.piccione@gmail.com>
 * @copyright  Copyright (c) 2018, Alfio Piccione
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2
 *
 * Copyright (C) 2018 Alfio Piccione <alfio.piccione@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

window.DL = window.DL || {};

;(
    function (_, $, google, dlnavGeocodeSuggestions, dllocalized, DL)
    {
        "use strict";

        DL.Search = DL.Search || {};

        /**
         * Listings Form Geocoded
         *
         * @since 1.0.0
         *
         * @type {Object}
         */
        DL.Search.Geocoded = {

            /**
             * Create Location Form Fields
             *
             * Add Geolocation data so Lat and Lng can be send with form.
             *
             * @since 1.0.0
             *
             * @return void
             */
            createLocationFormHiddenFields: function ()
            {
                // Do nothing if no location has been provided.
                if (_.isEmpty(this.location)) {
                    return;
                }

                // We can append the extra data to the form before send it.
                for (var prop in this.location) {
                    if (this.location.hasOwnProperty(prop)) {
                        // Let's create hidden inputs and set attributes and values.
                        // Then append it to the form, so we can submit the additional data.
                        var el = document.createElement('input');

                        el.setAttribute('type', 'hidden');
                        el.setAttribute('id', 'geocoded_hidden_data');
                        el.setAttribute('name', 'geocoded[' + prop + ']');
                        el.value = this.location[prop];

                        this.form.appendChild(el);
                    }
                }
            },

            /**
             * Delete Location Form Hidden Fields
             *
             * Delete the location geocoded previously created.
             *
             * This happen when we need to change context from a geocoded one to a static one.
             * See the `GooglePredictions` object for the `suggestionType` context
             *
             * @since 1.0.0
             *
             * @return void
             */
            deleteLocationFormHiddenFields: function ()
            {
                var hidden = this.form.querySelector('geocoded_hidden_data');
                if (hidden) {
                    hidden.remove();
                }
            },

            /**
             * Handle the form submit
             *
             * @since 1.0.0
             *
             * @param {Object} evt The event generated by the form submit
             */
            submit: function (evt)
            {
                evt.preventDefault();
                evt.stopImmediatePropagation();

                /**
                 * _Submit
                 *
                 * Internal function that submit form.
                 *
                 * Try to know which kind of data must be send.
                 * If a geocoded data or a custom suggestion data. Custom suggestion data are "locations" taxonomy terms.
                 * So when isn't request a geocoded data we want to submit the data of the "listing_locations".
                 *
                 * @type {function(this:DL)}
                 * @private
                 */
                var _submit = function ()
                {
                    // Retrieve the fragment for the taxonomy part.
                    // This allow us to redirect the user to the correct taxonomy page, depending on the tax
                    // used for the input.
                    var taxFrag = this.input.getAttribute('data-taxonomy');
                    taxFrag     = taxFrag ? '/' + taxFrag + '/' : '';

                    if (!this.predictioner.isGeocodeSuggestion()) {
                        this.predictioner.createLocationFilterFormField(evt.target);
                        this.deleteLocationFormHiddenFields();
                        this.form.setAttribute(
                            'action',
                            dllocalized.site_url + taxFrag + encodeURI(DL.Utils.String.toSlug(this.input.value))
                        );
                    } else {
                        this.predictioner.deleteLocationFilterFormField(evt.target);
                        // Create the location form fields so, them are send within the request.
                        this.createLocationFormHiddenFields();
                    }

                    // Submit data.
                    evt.target.submit();
                }.bind(this);

                // If no location has been created previously and we have an input value, let's geocode it.
                if (this.input.value && this.predictioner.isGeocodeSuggestion()) {
                    DL.Geo.GeocodeFactory(this.input.value, false).geocode(function (data)
                    {
                        // Store location.
                        this.location = data;
                        _submit();
                    }.bind(this), function (data)
                    {
                        ('dev' === dllocalized.env) && console.warn(data);
                        _submit();
                    }.bind(this));
                } else {
                    this.location = {};
                    _submit();
                }
            },

            /**
             * Initialize Object
             *
             * @since 1.0.0
             *
             * @returns {Object} The instance for chaining
             */
            init: function ()
            {
                // Initialize the predictioner.
                this.predictioner && this.predictioner.initUsing(this.input);

                // Intercept the Submit event.
                DL.Utils.Events.addListener(this.form, 'submit', this.submit, {
                    capture: true
                });

                // Geolocalize the user on trigger click.
                var userGeolocatorTrigger = this.form.querySelector('.dlgeolocalization-trigger');
                if (userGeolocatorTrigger) {
                    DL.Utils.Events.addListener(
                        userGeolocatorTrigger,
                        'click',
                        this.geocodeUserPosition,
                        {capture: true},
                        {form: this.form}
                    );
                }

                return this;
            },

            /**
             * Geocode User Position
             *
             * Retrieve the address and set it as input value.
             *
             * @since 1.0.0
             *
             * @param {Event}  evt      The event instance.
             * @param {Object} instance The instance of the object that contain the form.
             */
            geocodeUserPosition: function (evt, instance)
            {
                evt.preventDefault();
                evt.stopImmediatePropagation();

                // Show the loader within the search input.
                DL.Utils.UI.toggleLoader(evt.target);

                // Retrieve the current User position and geocoding it to show within the form input..
                this.userPosition.currentPosition(function ()
                {
                    // Set the geolocation so we can send the correct data on form submit.
                    this.location = {
                        lat: this.userPosition.lat(),
                        lng: this.userPosition.lng()
                    };

                    try {
                        // Try to geocode the location.
                        DL.Geo.GeocodeFactory({lat: this.userPosition.lat(), lng: this.userPosition.lng()}, true)
                          .geocode(function (data)
                          {
                              if (!this.input) {
                                  return;
                              }

                              // After geocoded the user position set the value to the search input.
                              this.input.value = data.address;

                              // Then dispatch the change event.
                              // The change event is not automatically dispatched on value set.
                              // Also, pass the data to the callback, so we can retrieve it later.
                              DL.Utils.Events.dispatchEvent('change', this.input, null, {geocode: data});

                              // Remove the loader after data has been retrieved.
                              DL.Utils.UI.toggleLoader(evt.target);
                          }.bind(this));
                    } catch (e) {
                        ('dev' === dllocalized.env) && console.warn(e);
                    }
                }.bind(this), function ()
                {
                    // Show the loader within the search input.
                    DL.Utils.UI.toggleLoader(evt.target);
                }.bind(this));
            },

            /**
             * Construct
             *
             * @since 1.0.0
             *
             * @return {Object} this for chaining
             */
            construct: function (form, userPosition, predictioner)
            {
                _.bindAll(
                    this,
                    'init',
                    'createLocationFormHiddenFields',
                    'deleteLocationFormHiddenFields',
                    'geocodeUserPosition',
                    'submit'
                );

                this.location     = null;
                this.userPosition = userPosition;
                this.form         = form;
                this.input        = this.form.querySelector('.is-geocoded');

                // Create the Google Search Box instance.
                this.predictioner = predictioner;

                return this;
            },
        };

        /**
         * Search Geocoded Factory
         *
         * @since 1.0.0
         *
         * @param form           The form element.
         * @param userPositioner The user position instance.
         * @param predictioner   The GooglePredictions instance.
         */
        DL.Search.GeocodedFactory = function (form, userPositioner, predictioner)
        {
            return Object.create(DL.Search.Geocoded).construct(form, userPositioner, predictioner);
        };

        /**
         * Google Predictions
         *
         * @since 1.0.0
         */
        var GooglePredictions = {
            /**
             * Retrieve the Navigation Search List Element
             *
             * @since 1.0.0
             *
             * @returns {Element|null} The HTML element or null if not found
             */
            navSearchListEl: function ()
            {
                return this.input.parentNode.querySelector('.dlnav-search .dlnav-search__list-items');
            },

            /**
             * Clean properties and Data
             *
             * @since 1.0.0
             *
             * @return {GooglePredictions} For chaining
             */
            clean: function ()
            {
                this.cleanTemplate();
                this.items          = '';
                this.predictions    = [];
                this.suggestionType = '';

                return this;
            },

            /**
             * Update Navigation height
             *
             * Used when the new items are set within the navigation
             *
             * @since 1.0.0
             *
             * @param {HTMLElement} nav The nav element
             */
            updateNavheight: function (nav)
            {
                if (!nav) {
                    return;
                }

                nav.style.height = _.reduce(nav.querySelectorAll('.menu-item'), function (r, v)
                {
                    return (r += v.offsetHeight);
                }, 0) + 'px';
            },

            /**
             * Hide Navigation
             *
             * @since 1.0.0
             *
             * @param {Function} callback Callback to execute after nav has been hidden.
             *
             * @returns {GooglePredictions} For chaining
             */
            hide: function (callback)
            {
                var nav = this.input.parentNode.querySelector('.dlnav-search');

                if (nav) {
                    $(nav).slideUp(275, function ()
                    {
                        // Mark as closed.
                        this.searchIsOpen = false;

                        DL.Utils.Functions.classList(nav).remove('dlnav-search--is-open');

                        // Remove the items from the nav if there is nothing to restore.
                        if ('' === this.input.value) {
                            this.clean();
                        }

                        if (_.isFunction(callback)) {
                            callback();
                        }
                    }.bind(this));
                }

                return this;
            },

            /**
             * Show Navigation
             *
             * @since 1.0.0
             *
             * @param {Function} callback Callback to execute after nav has been hidden.
             *
             * @returns {GooglePredictions} For chaining
             */
            show: function (callback)
            {
                var nav;

                if (this.items) {
                    nav = this.input.parentNode.querySelector('.dlnav-search');
                }

                if (nav) {
                    $(nav).slideDown(275, function ()
                    {
                        // Mark as opened.
                        this.searchIsOpen = true;

                        DL.Utils.Functions.classList(nav).add('dlnav-search--is-open');

                        if (_.isFunction(callback)) {
                            callback();
                        }

                        // Set the click event here after the navigation has been created.
                        _.forEach(this.navSearchListEl().querySelectorAll('.menu-item'), function (item)
                        {
                            DL.Utils.Events.addListener(item, 'click', this.setValueByEvent.bind(this, item), {
                                capture: true,
                                once: true
                            });
                        }.bind(this));

                        this.updateNavheight(nav);
                    }.bind(this));
                }

                return this;
            },

            /**
             * Render
             *
             * @since 1.0.0
             *
             * @returns {GooglePredictions} For chaning
             */
            render: function ()
            {
                if (this.items) {
                    this.cleanTemplate(function ()
                    {
                        var nav      = this.navSearchListEl(),
                            template = _.template(nav.innerText);

                        if (!template) {
                            throw "Cannot compile navigation template for geocode predictions.";
                        }

                        var compiled = template({items: this.items});
                        if (compiled) {
                            nav.innerHTML = compiled;
                        }

                        this.show();
                    }.bind(this));
                }

                return this;
            },

            /**
             * Render Suggestions
             *
             * Suggestions are custom menu items stored in dlnavGeocodeSuggestions variable.
             *
             * @since 1.0.0
             *
             * @return void
             */
            renderSuggestions: function ()
            {
                if (this.predictions.length) {
                    return;
                }

                if (!this.suggestionsCache) {
                    var itemsMarkup = '';
                    _.forEach(dlnavGeocodeSuggestions, function (item)
                    {
                        itemsMarkup += '<li class="menu-item" data-label="' + item.label +
                                       '" data-suggestion-type="static"><a href="#"><i class="' + item.icon + '"></i>' +
                                       item.label +
                                       '</a></li>';
                    });

                    this.suggestionsCache = itemsMarkup;
                }

                // Assign the items markup.
                this.items = this.suggestionsCache;

                // Show items.
                this.render();
            },

            /**
             * Clean Template
             *
             * @since 1.0.0
             *
             * @param callback The callback to call after cleaned the template.
             *
             * @returns {GooglePredictions} For chaining
             */
            cleanTemplate: function (callback)
            {
                this.input
                    .parentNode
                    .querySelector('.dlnav-search .dlnav-search__list-items')
                    .innerText = '<%= items %>';

                if (_.isFunction(callback)) {
                    callback();
                }

                return this;
            },

            /**
             * Create Template
             *
             * @since 1.0.0
             *
             * @returns {GooglePredictions} For chaining
             */
            createTemplate: function ()
            {
                // Don't try to create another one if all-ready exists.
                if (this.input.parentNode.querySelector('.dlnav-search')) {
                    return;
                }

                var element = document.querySelector('#dlnavigation-tmpl');
                // If template if found let's insert the inner HTML.
                element && this.input.parentNode.insertAdjacentHTML('beforeend', element.innerHTML);

                return this;
            },

            /**
             * Create Items
             *
             * @since 1.0.0
             *
             * @returns {GooglePredictions} For chaining
             */
            createItems: function ()
            {
                // Reset the items value, we want to show new data.
                this.items = '';

                if (this.predictions.length) {
                    _.forEach(this.predictions, function (prediction)
                    {
                        this.items += '<li class="menu-item" data-label="' + prediction.description +
                                      '" data-suggestion-type="google"><a href="#"><i class="la la-map-marker"></i>' +
                                      prediction.description +
                                      '</a></li>';
                    }.bind(this));
                }

                return this;
            },

            /**
             * Handle Input Key Down
             *
             * @since 1.0.0
             *
             * @param {Event} evt The event to handle
             */
            handleInputKeyDown: function (evt)
            {
                switch (evt.keyCode) {
                    // ESC
                    case 27:
                        this.hide();
                        break;

                    // Arrow Up
                    // Arrow Right
                    // Arrow Down
                    case 13:
                    case 38:
                    case 39:
                    case 40:
                        this.navigateThroughItems(evt.keyCode);

                        if (13 === evt.keyCode && this.searchIsOpen) {
                            evt.preventDefault();
                            evt.stopImmediatePropagation();
                        }
                        break;

                    default:
                        // Don't hide the nav if input is empty and there are no predictions.
                        // When there are no predictions the suggestions nav is showing and we want
                        // to keep it visible.
                        if ('' === this.input.value && !this.predictions.length) {
                            break;
                        }

                        // Hide nav if input has no value, since there is anything to predict.
                        if ('' === this.input.value) {
                            this.hide(this.renderSuggestions);
                            break;
                        }

                        this.googleAutocomplete.getPlacePredictions({
                            input: this.input.value
                        }, this.predict);
                        break;
                }
            },

            /**
             * Set Value
             *
             * @since 1.0.0
             *
             * @param {string} value The value to set.
             * @param {string} type The type of the suggestion.
             */
            setValue: function (value, type)
            {
                if (value) {
                    this.input.value    = value;
                    this.suggestionType = type;
                }
            },

            /**
             * Set Value By Event
             *
             * @since 1.0.0
             *
             * @param {Event} evt The current event
             */
            setValueByEvent: function (item, evt)
            {
                evt.preventDefault();
                evt.stopImmediatePropagation();

                this.setValue(
                    evt.target.parentNode.getAttribute('data-label'),
                    item.getAttribute('data-suggestion-type')
                );
            },

            /**
             * Is A Geocoded Suggestion or a static one?
             *
             * Is Geocode suggestion doesn't include the user position.
             *
             * @since 1.0.0
             *
             * @returns {boolean} true if geocoded, false otherwise.
             */
            isGeocodeSuggestion: function ()
            {
                return 'static' !== this.suggestionType;
            },

            /**
             * Create the Locations terms field
             *
             * This way we can send the data to the server that we want to show listings within the location taxonomy.
             *
             * @since 1.0.0
             *
             * @param {HTMLElement} form The form element in which append the input
             */
            createLocationFilterFormField: function (form)
            {
                var el = document.createElement('input');

                el.setAttribute('type', 'hidden');
                el.setAttribute('id', 'qibla_' + this.input.getAttribute('data-taxonomy') + '_filter');
                el.setAttribute('name', 'qibla_' + this.input.getAttribute('data-taxonomy') + '_filter');
                el.value = this.input.value;

                form.appendChild(el);
            },

            /**
             * Delete the Location Filter Field
             *
             * This is needed when we change the value of the input and not more search for a location term but
             * for a Geocoded value.
             *
             * @since 1.0.0
             *
             * @param {HTMLElement} form The form element from which append the input
             */
            deleteLocationFilterFormField: function (form)
            {
                var hidden = form.querySelector('qibla_' + this.input.getAttribute('data-taxonomy') + '_filter');
                if (hidden) {
                    hidden.remove();
                }
            },

            /**
             * Predict
             *
             * @since 1.0.0
             *
             * @param predictions
             * @param status
             *
             * @returns void
             */
            predict: function (predictions, status)
            {
                if (_.isEmpty(predictions) || status !== google.maps.places.PlacesServiceStatus.OK) {
                    this.cleanTemplate()
                        .hide();

                    return false;
                }

                this.predictions = predictions;

                this.createItems()
                    .render();
            },

            /**
             * Navigate Through Nav Items
             *
             * @since 1.0.0
             *
             * @param {int} keyCode The event key code
             */
            navigateThroughItems: function (keyCode)
            {
                // Do nothing if search is not opened.
                if (!this.searchIsOpen) {
                    return;
                }

                // Retrieve nav list items pointer.
                var searchNav       = this.navSearchListEl(),
                    currItem        = searchNav.querySelector('.is-selected'),
                    nextCurrentItem = null;

                // Check if there is a selected item.
                if (!currItem) {
                    // In case there is no element active, just select the first and add his label as value of the input.
                    DL.Utils.Functions.classList(searchNav.firstElementChild).add('is-selected');

                    // Set the input value.
                    this.setValue(
                        searchNav.firstElementChild.getAttribute('data-label'),
                        searchNav.firstElementChild.getAttribute('data-suggestion-type')
                    );
                    return;
                }

                switch (keyCode) {
                    // Arrow Up
                    case 38:
                    case 40:
                        // Check if the current element is the latest one in the list and the keycode it the arrow down.
                        // In this case nothing to do. No elements to select.
                        if (40 === keyCode && currItem === searchNav.lastElementChild) {
                            break;
                        }

                        // If the current element is the first one and the keycode is the arrow up
                        // clean the input value and done.
                        if (38 === keyCode && currItem === searchNav.firstElementChild) {
                            this.input.value = '';
                            break;
                        }

                        // Remove the selected class from the current element.
                        DL.Utils.Functions.classList(currItem).remove('is-selected');

                        // Select the next item.
                        if (40 === keyCode) {
                            nextCurrentItem = currItem.nextElementSibling;
                        }

                        if (38 === keyCode) {
                            nextCurrentItem = currItem.previousElementSibling;
                        }

                        // And add the selected class to the next current item.
                        nextCurrentItem && DL.Utils.Functions.classList(nextCurrentItem).add('is-selected');

                        // Add the new current item value as value of the input.
                        this.setValue(
                            nextCurrentItem.getAttribute('data-label'),
                            nextCurrentItem.getAttribute('data-suggestion-type')
                        );

                        // And set the new currentItem.
                        currItem        = nextCurrentItem;
                        nextCurrentItem = null;
                        break;

                    // Arrow Right
                    case 39:
                        // Check if input has value and if so, simply close the nav.
                        if (this.input.value) {
                            this.hide();
                        }
                        break;

                    // ENTER
                    case 13:
                        // If ENTER is pressed let's check if a value is selected, if so, just hide the nav.
                        if (this.input.value) {
                            this.hide();
                        }
                        break;
                }
            },

            /**
             * Init Using Input
             *
             * @since 1.0.0
             *
             * @param input
             */
            initUsing: function (input)
            {
                if (!input) {
                    return;
                }

                // Add autocomplete listener.
                if (this.googleAutocomplete instanceof google.maps.places.AutocompleteService) {
                    this.input = input;

                    // Create the template for the first time.
                    this.createTemplate();

                    // Set the event listener for when update the prediction list.
                    // Use keydown to prevent form submission.
                    DL.Utils.Events.addListener(this.input, 'keydown', this.handleInputKeyDown);

                    DL.Utils.Events.addListener(this.input, 'blur', this.hide);
                    DL.Utils.Events.addListener(this.input, ['click', 'focus'], this.renderSuggestions);
                    DL.Utils.Events.addListener(this.input, 'focus', this.show);
                }
            },

            /**
             * Construct
             *
             * @since 1.0.0
             *
             * @returns {GooglePredictions} For chaining
             */
            construct: function ()
            {
                _.bindAll(
                    this,
                    'initUsing',
                    'cleanTemplate',
                    'createItems',
                    'predict',
                    'render',
                    'hide',
                    'show',
                    'renderSuggestions',
                    'navigateThroughItems',
                    'setValueByEvent',
                    'handleInputKeyDown',
                    'createLocationFilterFormField',
                    'deleteLocationFilterFormField'
                );

                if (false === ('AutocompleteService' in google.maps.places)) {
                    return false;
                }

                // Lazy loaded.
                this.input              = null;
                this.googleAutocomplete = new google.maps.places.AutocompleteService();
                this.predictions        = [];
                this.items              = '';
                this.searchIsOpen       = false;
                this.suggestionType     = '';

                return this;
            },
        };

        /**
         * Google Predictions Factory
         *
         * @since 1.0.0
         *
         * @returns GooglePredictions The instance of GooglePredictions
         */
        var GooglePredictionsFactory = function ()
        {
            return Object.create(GooglePredictions).construct();
        };

        window.addEventListener('load', function ()
        {
            setTimeout(function ()
            {
                var forms = document.querySelectorAll('.dlsearch__form');

                _.forEach(forms, function (form)
                {
                    // Try to retrieve the element.
                    var geocodedField = form.querySelector('.is-geocoded');

                    if (geocodedField) {
                        var geocoded = DL.Search.GeocodedFactory(
                            form,
                            DL.Geo.UserPositionFactory(),
                            GooglePredictionsFactory()
                        );
                        geocoded && geocoded.init();
                    }
                });
            }, 0);
        });

    }(_, window.jQuery, window.google, window.dlnavGeocodeSuggestions, window.dllocalized, window.DL)
);

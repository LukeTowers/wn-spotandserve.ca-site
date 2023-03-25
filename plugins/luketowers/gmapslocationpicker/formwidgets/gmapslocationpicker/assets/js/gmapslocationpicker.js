/*
 * GMaps Location Picker plugin.
 */
+function ($, locationPicker, maps) { "use strict";

    var Base = $.wn.foundation.base,
        BaseProto = Base.prototype

    // GMAPS LOCATION PICKER CLASS DEFINITION
    // ============================

    var GMapsLocationPicker = function(element, options) {
        this.options     = options
        this.$el         = $(element)

        $.wn.foundation.controlUtils.markDisposable(element)

        Base.call(this)

        if (this.options.readOnly) {
            this.initReadOnly()
        } else {
            this.$lat = $('#' + this.$el.attr('data-lat-id'))
            this.$lng = $('#' + this.$el.attr('data-lng-id'))

            this.init()
        }
    }

    GMapsLocationPicker.prototype = Object.create(BaseProto)
    GMapsLocationPicker.prototype.constructor = GMapsLocationPicker

    GMapsLocationPicker.DEFAULTS = {
        readOnly: false
    }

    GMapsLocationPicker.prototype.initReadOnly = function() {
        var self = this;

        var pinLocation = {lat: this.options.lat, lng: this.options.lng};

        var map = new maps.Map(this.$el[0], {
            zoom: 20,
            center: pinLocation,
            streetViewControl: false,
            mapTypeId: 'satellite'
        });

        var marker = new maps.Marker({
            position: pinLocation,
            map: map
        });
    }

    GMapsLocationPicker.prototype.init = function() {
        var self = this;

        this.locationPicker = new locationPicker(this.$el.attr('id'), {}, {
            zoom: 20,
            streetViewControl: false,
            mapTypeId: 'satellite'
        });

        this.$el.parents('form').on('changedLocation', function () {
            self.locationPicker.setLocation(self.$lat.val(), self.$lng.val());
        });

        maps.event.addListener(this.locationPicker.map, 'idle', function (event) {
            // Get current location and show it in HTML
            var location = self.locationPicker.getMarkerPosition();

            self.updatingMarker = true;

            self.$lat.val(location.lat);
            self.$lng.val(location.lng);

            self.updatingMarker = false;

            console.log('The chosen location is ' + location.lat + ',' + location.lng);
        });
    }

    // GMAPS LOCATION PICKER PLUGIN DEFINITION
    // ============================

    var old = $.fn.gMapsLocationPicker

    $.fn.gMapsLocationPicker = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this   = $(this)
            var data    = $this.data('wn.gMapsLocationPicker')
            var options = $.extend({}, GMapsLocationPicker.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('wn.gMapsLocationPicker', (data = new GMapsLocationPicker(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.gMapsLocationPicker.Constructor = GMapsLocationPicker

    // GMAPS LOCATION PICKER NO CONFLICT
    // =================

    $.fn.gMapsLocationPicker.noConflict = function() {
        $.fn.gMapsLocationPicker = old
        return this
    }

    // GMAPS LOCATION PICKER DATA-API
    // ===============
    $(document).render(function() {
        $('[data-control="gmaps-location-picker"]').gMapsLocationPicker()
    })
}(window.jQuery, locationPicker, google.maps);
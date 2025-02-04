import $ from 'jquery';
jQuery(function($) {
    // Initialize Select2 for display type select
    $('#display_type').select2({
        minimumResultsForSearch: Infinity
    });

    // Handle taxonomy selection and term loading
    $('#selected_taxonomy').select2({}).on('change', function() {
        const selectedTaxonomy = $(this).val();
        
        $.ajax({
            url: magic_ef_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'magic_ef_get_taxonomy_terms',
                taxonomy: selectedTaxonomy,
                nonce: magic_ef_vars.nonce
            },
            beforeSend: function() {
                const $termsSelect = $('.magic-ef-term-select');
                $termsSelect.empty().prop('disabled', true);
                $('#terms_selection').hide();
                
                const $loader = $('<div class="magic-ef-loader">Loading...</div>');
                $('#taxonomy_options').append($loader);
            },
            success: function(response) {
                if(response.success && response.data?.length > 0) {
                    const $termsSelect = $('.magic-ef-term-select');
                    response.data.forEach(term => {
                        $termsSelect.append(new Option(term.name, term.term_id));
                    });
                    $('#terms_selection').show();
                }
            },
            complete: function() {
                $('.magic-ef-loader').remove();
                $('.magic-ef-term-select').prop('disabled', false);
            }
        });
    });

    // Initialize other Select2 instances
    $('#selected_products, .magic-ef-product-select, .magic-ef-term-select').select2();

    // Handle display options toggle
    $('.magic-ef-toggle input[type="checkbox"]').on('change', function() {
        const isActive = $(this).is(':checked');
        $('.magic-ef-display-options')
            .toggleClass('active', isActive)
            .toggle(isActive);
    });

    // Handle display type changes
    const handleDisplayType = (selectedValue) => {
        $('#specific_products').toggle(selectedValue === 'specific');
        $('#taxonomy_options').toggle(selectedValue === 'taxonomy');
    };

    $('#display_type').on('change', function() {
        handleDisplayType($(this).val());
    });

    // Initial display type handling
    handleDisplayType($('#display_type').val());

    // Popup handling
    const togglePopup = (show) => {
        $('.popup').toggleClass('show', show);
    };

    $('.page-title-action, .magic-ef-settings-btn').on('click', function(event) {
        event.preventDefault();
        togglePopup(true);
    });

    $('.close').on('click', () => togglePopup(false));

    $(window).on('click', function(event) {
        if ($(event.target).is('.popup')) {
            togglePopup(false);
        }
    });
});

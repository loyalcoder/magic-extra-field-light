import $ from 'jquery';
jQuery(function($) {
    // Initialize Choices.js for display type select
    $('#display_type').select2({
        minimumResultsForSearch: Infinity
    });
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
                // Show loading spinner before sending request
                const $termsSelect = $('.magic-ef-term-select');
                $termsSelect.empty().prop('disabled', true);
                $('#terms_selection').hide();
                
                const $loader = $('<div class="magic-ef-loader">Loading...</div>');
                $('#taxonomy_options').append($loader);
            },
            success: function(response) {
                if(response.success) {
                    const $termsSelect = $('.magic-ef-term-select');
                    
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(term) {
                            $termsSelect.append(new Option(term.name, term.term_id));
                        });
                    }
                    
                    $('#terms_selection').show();
                }
            },
            complete: function() {
                // Remove loader and re-enable select
                $('.magic-ef-loader').remove();
                $('.magic-ef-term-select').prop('disabled', false);
            }
        });
    });
    $('#selected_products').select2({
    });
    $('.magic-ef-product-select').select2({});
    $('.magic-ef-term-select').select2({
    });
    $('.magic-ef-toggle input[type="checkbox"]').on('change', function() {
        const isActive = $(this).is(':checked');
        $('.magic-ef-display-options').toggleClass('active', isActive);
        $('.magic-ef-display-options').css('display', isActive ? 'block' : 'none');
    });
    $('#display_type').on('change', function() {
        const selectedValue = $(this).val();
        if (selectedValue === 'specific') {
            $('#specific_products').show();
            $('#taxonomy_options').hide();
        } else if (selectedValue === 'taxonomy') {
            $('#taxonomy_options').show();
            $('#specific_products').hide();
        } else if (selectedValue === 'all') {
            $('#specific_products').hide();
            $('#taxonomy_options').hide();
        }
    });
    let displayType = $('#display_type').val();
    if (displayType === 'specific') {
        $('#specific_products').show();
        $('#taxonomy_options').hide();
    } else if (displayType === 'taxonomy') {
        $('#taxonomy_options').show();
        $('#specific_products').hide();
    }
    
    $('.page-title-action').on('click', function(event) {
        event.preventDefault();
        $('.popup').addClass('show');
    });
      // show settings popup
      $('.magic-ef-settings-btn').on('click', function(event) {
        console.log('clicked');
        $('.popup').addClass('show');
    });
    console.log('clicked');
    
    
    $('.close').on('click', function() {
        $('.popup').removeClass('show');
    });
    
    $(window).on('click', function(event) {
        if ($(event.target).is('.popup')) {
            $('.popup').removeClass('show');
        }
    });
  
    
});

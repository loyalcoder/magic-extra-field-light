import $ from 'jquery';
jQuery(function($) {
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
    
      // show settings popup
      $('.magic-ef-settings-btn').on('click', function(event) {
        event.preventDefault();
        $('.popup').addClass('show');
        // Show animated SVG preloader
        const loaderSvg = `
            <div class="magic-ef-loader">
                <svg width="38" height="38" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#2271b1">
                    <g fill="none" fill-rule="evenodd">
                        <g transform="translate(1 1)" stroke-width="2">
                            <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
                            <path d="M36 18c0-9.94-8.06-18-18-18">
                                <animateTransform
                                    attributeName="transform"
                                    type="rotate"
                                    from="0 18 18"
                                    to="360 18 18"
                                    dur="1s"
                                    repeatCount="indefinite"/>
                            </path>
                        </g>
                    </g>
                </svg>
            </div>
        `;
        $('.magic-ef-form').html(loaderSvg);
        // Make AJAX request to get form HTML
        $.ajax({
            url: magic_ef_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'magic_ef_get_settings_form',
                nonce: magic_ef_vars.nonce,
                post_id: $(this).data('id')
            },
            success: function(response) {
                if (response.success) {
                    $('.magic-ef-form').html(response.data);
                    $('.magic-ef-product-select').select2({
                        minimumInputLength: 1,
                        allowClear: true
                    });
                    $('select[name="display_type"]').select2({});
                    $('select[name="selected_taxonomy"]').select2({});
                    $('select[name="selected_terms[]"]').select2({});
                } else {
                    $('.magic-ef-form').html('<p class="error">Error loading settings form</p>');
                }
            },
            error: function() {
                $('.magic-ef-form').html('<p class="error">Error loading settings form</p>');
            }
        });
        // Remove preloader after form is fully loaded
    });    
    
    $('.close').on('click', function() {
        $('.popup').removeClass('show');
    });
    
    $(window).on('click', function(event) {
        if ($(event.target).is('.popup')) {
            $('.popup').removeClass('show');
        }
    });
  // handel save button
  $(document).on('change', 'input[name="is_active"], select[name="display_type"], select[name="selected_products[]"], select[name="selected_taxonomy"], select[name="selected_terms[]"]', function() {
    $('#magic-ef-save').prop('disabled', false);
    $('#magic-ef-edit-elementor').addClass('disabled');
    $('#magic-ef-edit-elementor').attr('href', 'javascript:void(0)');
    $('#magic-ef-edit-elementor').attr('target', '');
    $('.show-response').html('');
  })
  $(document).on('change', 'input[name="is_active"]', function() {
    const isActive = $(this).is(':checked');
    if (isActive) {
        $(this).parents('.magic-ef-toggle-wrapper').siblings('.magic-ef-display-options').show();
    } else {
        $(this).parents('.magic-ef-toggle-wrapper').siblings('.magic-ef-display-options').hide();
    }
  });
  $(document).on('change', 'select[name="display_type"]', function() {
    const displayType = $(this).val();
    
    if (displayType === 'all') {
        $(this).parents('.magic-ef-display-options').find('#specific_products, #taxonomy_options').hide();
    } else if (displayType === 'specific') {
        $(this).parents('.magic-ef-display-options').find('#specific_products').show();
        $(this).parents('.magic-ef-display-options').find('#taxonomy_options').hide();
    } else if (displayType === 'taxonomy') {
        $(this).parents('.magic-ef-display-options').find('#specific_products').hide();
        $(this).parents('.magic-ef-display-options').find('#taxonomy_options').show();
    }
  });
  // default display type
// Check initial active state and show/hide display options accordingly
    $(document).on('ajaxComplete', function() {
    const isActiveInitially = $('.magic-ef-form input[name="is_active"]').is(':checked');
    if (isActiveInitially) {
        $('.magic-ef-display-options').show();
    } else {
        $('.magic-ef-display-options').hide();
    }
    });
    // call ajax to get selected terms
    $(document).on('change', 'select[name="selected_taxonomy"]', function() {
        const selectedTaxonomy =    $(this).val();
        console.log(selectedTaxonomy);
        $.ajax({
            url: magic_ef_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'magic_ef_get_taxonomy_terms',
                taxonomy: selectedTaxonomy,
                nonce: magic_ef_vars.nonce
            },
            success: function(response) {
                if(response.success) {
                    $('select[name="selected_terms[]"]').empty().prop('disabled', true);
                    response.data.forEach(function(term) {
                        $('select[name="selected_terms[]"]').append(new Option(term.name, term.term_id));
                    });
                    $('select[name="selected_terms[]"]').prop('disabled', false);
                }
            }
        });
    });
    // save settings
    $(document).on('submit', '.magic-ef-form', function(e) {
        e.preventDefault();
        console.log($('.magic-ef-term-select').val());
        $.ajax({
            url: magic_ef_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'magic_ef_save_settings',
                nonce: magic_ef_vars.nonce,
                post_id: $(this).find('#magic-ef-save').data('post-id'),
                settings: $(this).serialize()
            },
            success: function(response) {
                if (response.success) {
                    $('.show-response').html('<div class="success">' + response.data.message + '</div>');
                    $('#magic-ef-edit-elementor').attr('href', response.data.edit_url);
                    $('#magic-ef-edit-elementor').removeClass('disabled');
                    $('#magic-ef-edit-elementor').attr('target', '_blank');
                    $('#magic-ef-save').prop('disabled', true);
                } else {
                    $('.show-response').html('<div class="error">' + response.message + '</div>');
                }
            }
        });
    });
});

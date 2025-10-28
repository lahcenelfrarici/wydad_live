(function ($, Drupal) {
    Drupal.behaviors.dynamicSubprofile = {
      attach: function (context, settings) {
        $('select[name="profile"]', context).each(function() { // Removed .once() for now
          $(this).on('change', function() {
            var profileId = $(this).val();
            var $subprofileSelect = $('select[data-subprofile-select]');
            if (!profileId || profileId == 'All') {
              $subprofileSelect.prop('disabled', true);
              $subprofileSelect.html('<option value="All" selected="selected">' + Drupal.t('- Select a profile first -') + '</option>');
            } else {
              $subprofileSelect.prop('disabled', true);
              $.ajax({
                url: '/dynamic-subprofile/get-subprofiles',
                data: { profile_id: profileId },
                dataType: 'json',
                success: function(data) {
                  var options = '<option value="All">' + Drupal.t('- Select a subprofile -') + '</option>';
                  $.each(data, function(key, value) {
                    options += '<option value="' + key + '">' + value + '</option>';
                  });
                  $subprofileSelect.html(options);
                  $subprofileSelect.prop('disabled', false);
                },
                error: function() {
                  $subprofileSelect.html('<option value="">' + Drupal.t('- Error loading subprofiles -') + '</option>');
                  $subprofileSelect.prop('disabled', true);
                }
              });
            }
          });
        });
  
        // Trigger change on page load to set initial state
        $('select[name="profile"]', context).trigger('change');
      }
    };
  })(jQuery, Drupal);
  
  
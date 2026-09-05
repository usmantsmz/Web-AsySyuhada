jQuery(document).ready(function($) {

    // Toggle Wali Fields
    $('#toggle_wali_check').on('change', function() {
        if ($(this).is(':checked')) {
            $('#wali_fields_box').slideDown();
        } else {
            $('#wali_fields_box').slideUp();
        }
    });

    // Multi-step Navigation
    $('.btn-next-step').on('click', function(e) {
        e.preventDefault();
        var currentPane = $(this).closest('.spmb-form-step');
        var nextStep = $(this).data('next');

        // Basic required field validation in current pane
        var valid = true;
        currentPane.find('input[required], select[required], textarea[required]').each(function() {
            if (!$(this).val()) {
                valid = false;
                $(this).addClass('field-error').css('border-color', 'red');
            } else {
                $(this).removeClass('field-error').css('border-color', '#cbd5e1');
            }
        });

        if (!valid) {
            alert('Mohon lengkapi seluruh kolom wajib bertanda bintang (*) pada tahap ini.');
            return false;
        }

        // If navigating to Review step (5), populate summary
        if (nextStep == 5) {
            populateReviewSummary();
        }

        // Switch active step
        $('.spmb-form-step').removeClass('active');
        $('.step-pane-' + nextStep).addClass('active');

        updateStepIndicator(nextStep);

        window.scrollTo({ top: $('.spmb-form-wrapper').offset().top - 40, behavior: 'smooth' });
    });

    $('.btn-prev-step').on('click', function(e) {
        e.preventDefault();
        var prevStep = $(this).data('prev');
        $('.spmb-form-step').removeClass('active');
        $('.step-pane-' + prevStep).addClass('active');
        updateStepIndicator(prevStep);
        window.scrollTo({ top: $('.spmb-form-wrapper').offset().top - 40, behavior: 'smooth' });
    });

    function updateStepIndicator(stepNum) {
        $('.spmb-step-bar .step-item').each(function() {
            var itemStep = $(this).data('step');
            if (itemStep < stepNum) {
                $(this).addClass('completed').removeClass('active');
            } else if (itemStep == stepNum) {
                $(this).addClass('active').removeClass('completed');
            } else {
                $(this).removeClass('active completed');
            }
        });
    }

    // Populate Review Summary
    function populateReviewSummary() {
        var form = $('#spmb-public-reg-form');
        var html = '<table class="spmb-review-table">';
        
        html += '<tr><th>NISN:</th><td>' + (form.find('[name="nisn"]').val() || '-') + '</td></tr>';
        html += '<tr><th>NIK Siswa:</th><td>' + (form.find('[name="nik"]').val() || '-') + '</td></tr>';
        html += '<tr><th>Nama Lengkap:</th><td><strong>' + (form.find('[name="full_name"]').val() || '-') + '</strong></td></tr>';
        html += '<tr><th>Tempat, Tgl Lahir:</th><td>' + (form.find('[name="pob"]').val() || '-') + ', ' + (form.find('[name="dob"]').val() || '-') + '</td></tr>';
        html += '<tr><th>Jenis Kelamin / Agama:</th><td>' + (form.find('[name="gender"]').val() == 'L' ? 'Laki-laki' : 'Perempuan') + ' / ' + (form.find('[name="religion"]').val() || '-') + '</td></tr>';
        html += '<tr><th>No. HP / WA:</th><td>' + (form.find('[name="phone"]').val() || '-') + '</td></tr>';
        html += '<tr><th>Email:</th><td>' + (form.find('[name="email"]').val() || '-') + '</td></tr>';
        html += '<tr><th>Alamat Lengkap:</th><td>' + (form.find('[name="address"]').val() || '-') + ' (Kel: ' + (form.find('[name="kelurahan"]').val() || '-') + ', Kec: ' + (form.find('[name="kecamatan"]').val() || '-') + ')</td></tr>';
        html += '<tr><th>Sekolah Asal:</th><td>' + (form.find('[name="school_origin"]').val() || '-') + '</td></tr>';
        html += '<tr><th>Nama Ayah / Ibu:</th><td>' + (form.find('[name="ayah_name"]').val() || '-') + ' / ' + (form.find('[name="ibu_name"]').val() || '-') + '</td></tr>';

        // Check attached files
        var fileList = [];
        $('.spmb-file-input').each(function() {
            var fileName = $(this).val() ? $(this).val().split('\\').pop() : 'Belum diunggah';
            var reqTitle = $(this).data('req-title') || 'Dokumen';
            fileList.push(reqTitle + ': <em>' + fileName + '</em>');
        });
        html += '<tr><th>Dokumen Diunggah:</th><td>' + fileList.join('<br>') + '</td></tr>';

        html += '</table>';
        $('#spmb-review-container').html(html);
    }

    // Submit Registration via AJAX
    $('#spmb-public-reg-form').on('submit', function(e) {
        e.preventDefault();

        if (!$('#declaration_agree').is(':checked')) {
            alert('Anda wajib menyetujui pernyataan keabsahan data sebelum mengirim formulir.');
            return false;
        }

        var btn = $('#spmb-btn-submit-form');
        var originalText = btn.html();
        btn.prop('disabled', true).html('⌛ Memproses Pendaftaran...');

        var formData = new FormData(this);

        $.ajax({
            url: spmb_obj.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $('#spmb-public-reg-form').slideUp();
                    $('.spmb-step-bar').hide();
                    $('#success-reg-no').text(response.data.reg_no);
                    $('#spmb-success-screen').slideDown();
                    window.scrollTo({ top: $('.spmb-form-wrapper').offset().top - 40, behavior: 'smooth' });
                } else {
                    alert('Terjadi kesalahan: ' + (response.data || 'Gagal mengirim data'));
                    btn.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                alert('Gagal terhubung ke server. Silakan periksa koneksi internet Anda.');
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Search Selection Result via AJAX
    $('#spmb-search-result-form').on('submit', function(e) {
        e.preventDefault();
        var query = $('#search_query').val().trim();
        if (query.length < 3) {
            alert('Masukkan minimal 3 karakter pencarian.');
            return;
        }

        var container = $('#spmb-search-results-container');
        container.html('<div style="text-align:center; padding:20px; color:#0d5c3a;">⌛ Mencari data hasil seleksi...</div>');

        $.ajax({
            url: spmb_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'spmb_search_selection',
                nonce: spmb_obj.nonce,
                query: query
            },
            success: function(res) {
                if (res.success) {
                    container.html(res.data.html);
                } else {
                    container.html('<div class="spmb-no-result">' + res.data + '</div>');
                }
            },
            error: function() {
                container.html('<div class="spmb-no-result">Gagal terhubung ke server.</div>');
            }
        });
    });
});

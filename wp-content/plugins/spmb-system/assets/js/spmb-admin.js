jQuery(document).ready(function($) {

    // 1. OPEN APPLICANT DETAIL MODAL
    $(document).on('click', '.btn-open-detail', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        $('#spmb-detail-modal').show();
        $('#spmb-modal-body').html('<div class="spmb-spinner">⌛ Memuat detail pendaftar...</div>');

        $.ajax({
            url: spmb_admin_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'spmb_get_applicant_detail',
                nonce: spmb_admin_obj.nonce,
                id: id
            },
            success: function(res) {
                if (res.success) {
                    $('#spmb-modal-title').text('Detail Pendaftar: ' + res.data.reg_no + ' - ' + res.data.name);
                    $('#spmb-modal-body').html(res.data.html);
                } else {
                    $('#spmb-modal-body').html('<div style="color:red;">Error: ' + res.data + '</div>');
                }
            },
            error: function() {
                $('#spmb-modal-body').html('<div style="color:red;">Gagal terhubung ke server.</div>');
            }
        });
    });

    // CLOSE MODAL
    $(document).on('click', '.spmb-modal-close, .spmb-modal-overlay', function() {
        $('#spmb-detail-modal').hide();
    });

    // SWITCH DETAIL TABS
    $(document).on('click', '.spmb-detail-tabs .tab-btn', function() {
        var targetTab = $(this).data('tab');
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');

        $('.spmb-tab-pane').removeClass('active');
        $('#' + targetTab).addClass('active');
    });

    // UPDATE DOCUMENT VERIFICATION STATUS
    $(document).on('change', '.spmb-doc-status-select', function() {
        var docId = $(this).data('doc-id');
        var status = $(this).val();

        $.ajax({
            url: spmb_admin_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'spmb_update_doc_status',
                nonce: spmb_admin_obj.nonce,
                doc_id: docId,
                status: status
            },
            success: function(res) {
                if (res.success) {
                    alert('Status dokumen berhasil diperbarui!');
                }
            }
        });
    });

    // UPDATE APPLICANT STATUS FORM
    $(document).on('submit', '#spmb-update-status-form', function(e) {
        e.preventDefault();
        var appId = $(this).data('applicant-id');
        var status = $('#applicant_status_select').val();
        var note = $('#admin_note_textarea').val();

        $.ajax({
            url: spmb_admin_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'spmb_update_applicant_status',
                nonce: spmb_admin_obj.nonce,
                id: appId,
                status: status,
                admin_note: note
            },
            success: function(res) {
                if (res.success) {
                    alert(res.data);
                    location.reload();
                } else {
                    alert('Error: ' + res.data);
                }
            }
        });
    });

    // 2. REQUIREMENTS MANAGER
    $('#spmb-req-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize() + '&action=spmb_save_requirement&nonce=' + spmb_admin_obj.nonce;

        $.ajax({
            url: spmb_admin_obj.ajax_url,
            type: 'POST',
            data: formData,
            success: function(res) {
                if (res.success) {
                    alert(res.data);
                    location.reload();
                }
            }
        });
    });

    $(document).on('click', '.btn-edit-req', function() {
        var data = $(this).data('json');
        $('#req_id').val(data.id);
        $('#req_title').val(data.title);
        $('#req_description').val(data.description);
        $('#req_allowed_formats').val(data.allowed_formats);
        $('#req_max_size_mb').val(data.max_size_mb);
        $('#req_is_required').prop('checked', data.is_required == 1);
        $('#req_sort_order').val(data.sort_order);

        $('#req-form-title').text('Edit Persyaratan #' + data.id);
        $('#btn-cancel-req').show();
    });

    $('#btn-cancel-req').on('click', function() {
        $('#spmb-req-form')[0].reset();
        $('#req_id').val(0);
        $('#req-form-title').text('Tambah Persyaratan Baru');
        $(this).hide();
    });

    $(document).on('click', '.btn-delete-req', function() {
        if (!confirm('Hapus persyaratan dokumen ini?')) return;
        var id = $(this).data('id');

        $.ajax({
            url: spmb_admin_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'spmb_delete_requirement',
                nonce: spmb_admin_obj.nonce,
                id: id
            },
            success: function() {
                location.reload();
            }
        });
    });

    // 3. SCHEDULE MANAGER
    $('#spmb-sched-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize() + '&action=spmb_save_schedule&nonce=' + spmb_admin_obj.nonce;

        $.ajax({
            url: spmb_admin_obj.ajax_url,
            type: 'POST',
            data: formData,
            success: function(res) {
                if (res.success) {
                    alert(res.data);
                    location.reload();
                }
            }
        });
    });

    $(document).on('click', '.btn-edit-sched', function() {
        var data = $(this).data('json');
        $('#sched_id').val(data.id);
        $('#sched_title').val(data.event_title);
        $('#sched_start_date').val(data.start_date);
        $('#sched_end_date').val(data.end_date);
        $('#sched_description').val(data.description);
        $('#sched_sort_order').val(data.sort_order);

        $('#sched-form-title').text('Edit Agenda #' + data.id);
        $('#btn-cancel-sched').show();
    });

    $('#btn-cancel-sched').on('click', function() {
        $('#spmb-sched-form')[0].reset();
        $('#sched_id').val(0);
        $('#sched-form-title').text('Tambah Agenda Baru');
        $(this).hide();
    });

    $(document).on('click', '.btn-delete-sched', function() {
        if (!confirm('Hapus agenda jadwal ini?')) return;
        var id = $(this).data('id');

        $.ajax({
            url: spmb_admin_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'spmb_delete_schedule',
                nonce: spmb_admin_obj.nonce,
                id: id
            },
            success: function() {
                location.reload();
            }
        });
    });

    // 4. SETTINGS FORM
    $('#spmb-settings-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize() + '&action=spmb_save_settings&nonce=' + spmb_admin_obj.nonce;

        $.ajax({
            url: spmb_admin_obj.ajax_url,
            type: 'POST',
            data: formData,
            success: function(res) {
                if (res.success) {
                    alert(res.data);
                    location.reload();
                }
            }
        });
    });

    // 5. SELECTION RESULTS MANAGER
    $(document).on('click', '.btn-save-selection', function() {
        var row = $(this).closest('tr');
        var appId = $(this).data('id');

        var data = {
            action: 'spmb_save_selection',
            nonce: spmb_admin_obj.nonce,
            applicant_id: appId,
            participant_no: row.find('.input-participant-no').val(),
            ranking: row.find('.input-ranking').val(),
            score: row.find('.input-score').val(),
            status: row.find('.select-sel-status').val(),
            notes: row.find('.input-sel-notes').val()
        };

        $.ajax({
            url: spmb_admin_obj.ajax_url,
            type: 'POST',
            data: data,
            success: function(res) {
                if (res.success) {
                    alert('Hasil seleksi pendaftar berhasil disimpan!');
                }
            }
        });
    });

    // TOGGLE PUBLISH SELECTION
    $('#btn-toggle-publish').on('click', function() {
        $.ajax({
            url: spmb_admin_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'spmb_toggle_publish_selection',
                nonce: spmb_admin_obj.nonce
            },
            success: function(res) {
                if (res.success) {
                    location.reload();
                }
            }
        });
    });
});

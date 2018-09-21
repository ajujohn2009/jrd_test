    var searchable_keys = ["First Name", "Date Added"];
    var search_query = {
        "first_name" : null,
        "min_date": null,
        "max_date" : null
    };
    var table;
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host;
    // var baseUrl = getUrl .protocol + "//" + getUrl.host + '/student';
    var studentUrl =  baseUrl + '/student'
    var classUrl =  baseUrl + '/class'

    initializeDataTable();
    addRangeInput();

    /**
        To add input to the column header date_added and first name
    **/
    function addRangeInput () {
        $('#studentTbl thead th').each( function () {
            var title = $(this).text();
            if(searchable_keys.indexOf(title) === 0) {
                $(this).append( '<br/><input type="text" class="searchFilter form-control" placeholder="Search '+title+'" />' );
            }
            if(searchable_keys.indexOf(title) === 1) { 
                $(this).append( '<div class="date-range">'+
                        '<input type="text" id="min-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">'+
                        '<input type="text" id="max-date" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">' );
            }
        });
    }
    
    /**
        This function will initialize the Data Table
    **/
    function initializeDataTable() {
        table = $('#studentTbl').DataTable({
                    paging: true,
                    ordering: false,
                    pageLength: pageLimit,
                    bFilter: false,
                    bLengthChange: false,
                    bInfo : true,
                    preDrawCallback: function( settings ) {
                        $('#deleteRecord').attr('disabled', true);
                        $('#editBtn').attr('disabled', true);
                    },
                    ajax: function ( data, callback, settings ) {
                        $.ajax({
                            url: studentUrl + '/getStudentData',
                            type: 'get',
                            contentType: 'application/x-www-form-urlencoded',
                            data: {
                                offset: data.start,
                                limit: data.length,
                                search_query: search_query
                            },
                            success: function( data, textStatus, jQxhr ){
                                var data = JSON.parse(data);
                                callback({
                                    data: data.data,
                                    recordsTotal:  data.offset[0],
                                    recordsFiltered:  data.offset[0]
                                });
                            },
                            error: function( jqXhr, textStatus, errorThrown ){
                            }
                        });
                    },
                    serverSide: true

                });
    }
    
 
    var yearsToShow = [];
    var currentYear = (new Date()).getFullYear();

    //To show the record as selected/unselected on clicking the row
    $('#studentTbl tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            $('#deleteRecord').attr('disabled', true);
            $('#editBtn').attr('disabled', true);
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $('#deleteRecord').attr('disabled', false);
            $('#editBtn').attr('disabled', false);

        }
    });

    //To set the student record on Add modal opening
    $('#addNewModal').on('shown.bs.modal', function () {
        $('.new-form').find('.fname').val('');
        $('.new-form').find('.lname').val('');
        $('.new-form').find('.dob').val('');
        $('.new-form').find('.guardianName').val('');
        $('.new-form').find('.email').val('');
        $('.new-form').find('.className').val('');
        $('.new-form').find('.phoneNumber').val('');
        $('.new-form').find('.yearJoined').val('');
        $.ajax({
            url: classUrl + "/getAllClasses",
            type: 'GET',
            success: function (res)
                 { 
                    var res = JSON.parse(res);
                    var dropdown_html = "<option value=''>Select</option>";
                    res.forEach(function(v, i) {
                        dropdown_html += "<option value='"+ v.id +"'>" + v.class_name + "</option>";
                    });
                    $('.new-form .className').html(dropdown_html);
                }
         }); 
         var dropdown_html = "<option value=''>Select</option>"; 
        for(var i= +currentYear; i >= 1980; i--) {
            dropdown_html += "<option value='"+ i +"'>" + i + "</option>";
        }
        $('.new-form .yearJoined').html(dropdown_html);
    });

    //To set the student record on edit modal opening
    $('#editDataModal').on('shown.bs.modal', function () {
        var rowData = table.row('.selected').data();
        var studentRecord = {
            "first_name": rowData.first_name,
            "last_name" : rowData.last_name,
            "dob": rowData.dob,
            "guardian_name":  rowData.guardian_name,
            "email":  rowData.email,
            "className" : rowData.jrd_class_id,
            "phone": rowData.phone,
            "year_joined": rowData.year_joined

          }
        var dropdown_html = "<option value=''>Select</option>"; 
        for(var i= +currentYear; i >= 1980; i--) {
            dropdown_html += "<option value='"+ i +"'>" + i + "</option>";
        }
        $('.edit-form .yearJoined').html(dropdown_html);

        //To get all classes from Database and add it is as an option in the dropdown
        $.ajax({
            url: classUrl + "/getAllClasses",
            type: 'GET',
            success: function (res) { 
                var res = JSON.parse(res);
                var dropdown_html = "<option value=''>Select</option>";
                res.forEach(function(v, i) {
                    dropdown_html += "<option value='"+ v.id +"'>" + v.class_name + "</option>";
                });

                $('.edit-form .className').html(dropdown_html);

                $('.edit-form').find('.fname').val(studentRecord.first_name);
                $('.edit-form').find('.lname').val(studentRecord.last_name);
                $('.edit-form').find('.dob').val(studentRecord.dob);
                $('.edit-form').find('.guardianName').val(studentRecord.guardian_name);
                $('.edit-form').find('.email').val(studentRecord.email);
                $('.edit-form').find('.className').val(studentRecord.className);
                $('.edit-form').find('.phoneNumber').val(studentRecord.phone);
                $('.edit-form').find('.yearJoined').val(studentRecord.year_joined);
            }
         }); 
         
    });

    //To trigger the modal window open for edit
    $('#editBtn').click( function () {
        if(table.$('tr.selected').length > 0){
            $("#editDataModal").modal('show');
        }
    });
    //To trigger the delete action from delete button
    $('#deleteRecord').click( function () {
        if(table.$('tr.selected').length > 0){
            if(confirm('Are you sure you want delete the record?')) {
                var rowData = table.row('.selected').data();
                deleteRecord(rowData.id);
            }
            
        }
    });

    //Function to delete the record from DB
    function deleteRecord(recordToDelete) {
        $.ajax({
            url: studentUrl + "/deleteStudentData",
            type: 'POST',
            data: {
                  "student_id": recordToDelete,
            },
            success: function (res) { 
                var res = JSON.parse(res);
                if(res.success) {
                    table.row('.selected').remove().draw( false );
                    $('#deleteRecord').attr('disabled', true);
                    $('#editBtn').attr('disabled', true);

                }
            }
         });  
    }


    /**
        common function for Add and Edit modal 
        this function will submit the modal form and call the appropriate function (Add or Edit)
    **/
    function submitModalData (e) {
        var thisObj = $(e.target);
        var form = thisObj.closest('form')[0];
        if(form.checkValidity()){
            e.preventDefault();
            if(thisObj.hasClass('addFormBtn')) {
                //New form
                addNewData();
            } else if(thisObj.hasClass('editFormBtn')) {
                //Edit Form
                updateData();
            }
        }
    }
    /**
        To add new record to the DB
    **/
    function addNewData () {
        var student = getFormData($('.new-form'));
        $.ajax({
            url: studentUrl + "/addStudent",
            type: 'POST',
            data: {'student' : student},
            success: function (res)
                 { 
                    var res = JSON.parse(res);
                    if(res.status) {
                        table.row('.selected').remove().draw( false );
                        $('#deleteRecord').attr('disabled', true);
                        $('#editBtn').attr('disabled', true);
                        $('#addNewModal').modal('toggle');
                    } else {
                        //if any DB error
                        alert(res.message)
                    }
                }
         }); 
    }
    /**
        fetch the form data and prepare a single object
        return student object
    **/
    function getFormData (obj) {
        var student = {};
        student.first_name = obj.find('.fname').val();
        student.last_name = obj.find('.lname').val();
        student.dob = obj.find('.dob').val();
        student.guardian_name = obj.find('.guardianName').val();
        student.email = obj.find('.email').val();
        student.jrd_class_id = obj.find('.className').val();
        student.phone = obj.find('.phoneNumber').val();
        student.year_joined = obj.find('.yearJoined').val();
        return student;
    }

    /**
        To update the selected record in the DB
    **/
    function updateData () {
        var student = getFormData($('.edit-form'));
        var rowData = table.row('.selected').data();
        console.log(rowData)
        $.ajax({
            url: studentUrl + "/updateStudent/" + rowData.id,
            type: 'POST',
            data: {'student' : student},
            success: function (res)
                 { 
                    var res = JSON.parse(res);
                    if(res.status) {
                        table.row('.selected').remove().draw( false );
                        $('#deleteRecord').attr('disabled', true);
                        $('#editBtn').attr('disabled', true);
                        $('#editDataModal').modal('toggle');
                    } else {
                        //if any DB error
                        alert(res.message);
                    }
                }
         }); 
    }
    
    $(document).ready(function(){ 
        //To add datepicker to the Date Added search boxes
        $('.date-range input').each(function(i,v) {
            $(v).datepicker();
        });

        //To bind change event to the daterange datepicker
        $('.date-range-filter').change(function() {
            var min = $('#min-date').val();
            var max = $('#max-date').val();

            search_query['min_date'] = min;
            search_query['max_date'] = max;
            table.draw();
        });
    });

    //Bind data table search boxes to search
    table.columns().every( function (b, x, z) {
        var that = this;
        if(b !== 1) { //Only binding for firstName
            return;
        }
         $('input', this.header() ).on( 'click', function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
        var prevText = "";
        $('input', this.header() ).on( 'keyup', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('.type-hint').css('visibility', 'hidden')
            if ( that.search() !== this.value) {
                if(this.value.length > 2) {
                    // If the search length is greater than 2 chars
                    search_query['first_name'] = this.value;
                    that.search( this.value ).draw();
                    $('.type-hint').css('visibility', 'hidden')
                    prevText = this.value;
                } else if(prevText.length > this.value.length) {
                    // If the search length is greater than 2 chars
                    search_query['first_name'] = "";
                    that.search( this.value ).draw();
                    $('.type-hint').css('visibility', 'visible')
                    prevText = this.value;
                } else if(this.value.length == 0) {
                    search_query['first_name'] = "";
                    that.search( this.value ).draw();
                    prevText = this.value;
                    $('.type-hint').css('visibility', 'hidden')
                } else if(this.value.length < 3) {
                    $('.type-hint').css('visibility', 'visible')
                }
                
            }
        });
    });
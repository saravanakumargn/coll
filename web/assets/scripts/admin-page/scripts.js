function collegeChange(val) {
//   console.log(val)
    var columns = val.split(/\r?\n/);
//   console.log(columns);
    //for(i=0; i < columns.length; i++){
    for (i = 0; i < 4; i++) {
        if (columns[i]) {
            var name = columns[i].trim();
//     console.log(name);    
            switch (i) {
                case 0:
                    if (name !== '--' && name.length >= 5) {
                        $('#cPhoneNo').val(name);
                    } else {
                        $('#cPhoneNo').val('');
                    }
                    break;
                case 1:
                    if (name !== '--' && name.length >= 5) {
                        $('#cFaxNo').val(name);
                    } else {
                        $('#cFaxNo').val('');
                    }
                    break;
                case 2:
                    if (name !== '--' && name.length >= 5) {
                        $('#cEmailId').val(name);
                    } else {
                        $('#cEmailId').val('');
                    }
                    break;
                case 3:
                    if (name !== '--' && name.length >= 5) {
                        $('#cWeb').val(name);
                    } else {
                        $('#cWeb').val('');
                    }
                    break;
            }
        }
    }

}


function branchesChange(val) {
    // console.log(val);
    var columns = val.split(/\r?\n/);
    // console.log(columns);
    for (i = 0; i < columns.length; i++) {
        if (columns[i]) {
            var courseAray = columns[i].trim();
            // console.log(name);
            var items = courseAray.split(/\r?\t/);
            // console.log(items)
            console.log('*********')
            for (j = 0; j < items.length; j++) {
                var item = items[j].trim();
                if (item.length > 0) {
                    console.log(item)
                }
            }
        }
    }
}
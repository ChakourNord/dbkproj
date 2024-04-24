/**
 * Created by Altab-01 on 14/11/2019.
 */

$(document).ready(function() {
});

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

/*
function getPersonalDataByType(type)
{
    var cookie = JSON.parse(getCookie('personal_data'));
    switch (type)
    {
        case 'name':
            return cookie.name;
        case 'surname':
            return cookie.surname;
        case 'url':
            if(cookie.url == '')
                return '../assets/images/profile_placeholder.png';
            return cookie.url;
    }
}
*/

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

function goBack() {
    window.history.back();
}

function resetLocalStorage(key) {
    localStorage.removeItem(key);
}

function isCompliance(check)
{
    var value_selected;
    var today;

    // Input: Si/No
    if(check.is_flag &&
        !check.is_step &&
        !check.is_expiration_date &&
        !check.is_text &&
        !check.is_number &&
        !check.is_photo &&
        !check.is_consumable)
    {
        return check.value_flag == 1;
    }

    // Input: Numero Libero
    if(!check.is_flag &&
        !check.is_step &&
        !check.is_expiration_date &&
        !check.is_text &&
        check.is_number &&
        !check.is_photo &&
        !check.is_consumable)
    {
        return true;
    }

    // Input: Consumabile
    if(!check.is_flag &&
        !check.is_step &&
        !check.is_expiration_date &&
        !check.is_text &&
        check.is_number &&
        !check.is_photo &&
        check.is_consumable)
    {
        //if(check.value_number > check.number_error_at && check.value_number <= check.number_max)
		if(check.value_number > check.number_error_at)
            return true;
    }

    // Input: Consumabile + Data di Scadenza
    if(!check.is_flag &&
        !check.is_step &&
        check.is_expiration_date &&
        !check.is_text &&
        check.is_number &&
        !check.is_photo &&
        check.is_consumable)
    {
        value_selected = new Date(check.value_date);
        today = new Date();
        //if(check.value_number > check.number_error_at && check.value_number <= check.number_max && today.getTime() <= value_selected.getTime())
		if(check.value_number > check.number_error_at && today.getTime() <= value_selected.getTime())
            return true;
    }

    // Input: Si/No + Livello
    if(check.is_flag &&
        check.is_step &&
        !check.is_expiration_date &&
        !check.is_text &&
        !check.is_number &&
        !check.is_photo &&
        !check.is_consumable)
    {
        if((check.value_slider * (check.slider_max / check.slider_step)) > check.slider_error_at)
            return true;
    }

    // Input: Si/No + Data di Scadenza
    if(check.is_flag &&
        !check.is_step &&
        check.is_expiration_date &&
        !check.is_text &&
        !check.is_number &&
        !check.is_photo &&
        !check.is_consumable)
    {
        value_selected = new Date(check.value_date);
        today = new Date();
        if(today.getTime() <= value_selected.getTime())
            return true;
    }

    // Input: Si/No + Note
    if(check.is_flag &&
        !check.is_step &&
        !check.is_expiration_date &&
        check.is_text &&
        !check.is_number &&
        !check.is_photo &&
        !check.is_consumable)
    {
        return check.value_flag == 1;
    }

    // Input: Si/No + Upload Foto
    if(check.is_flag &&
        !check.is_step &&
        !check.is_expiration_date &&
        !check.is_text &&
        !check.is_number &&
        check.is_photo &&
        !check.is_consumable)
    {
        return check.photos.length == 4;
    }

    // Input: Note Libere
    if(!check.is_flag &&
        !check.is_step &&
        !check.is_expiration_date &&
        check.is_text &&
        !check.is_number &&
        !check.is_photo &&
        !check.is_consumable)
    {
        return true;
    }

    return false;
}

/* ----- EXIF ROTATION SCRIPT ----- */
/*
function _arrayBufferToBase64(buffer) {
    var binary = ''
    var bytes = new Uint8Array(buffer)
    var len = bytes.byteLength;
    for (var i = 0; i < len; i++) {
        binary += String.fromCharCode(bytes[i])
    }
    return window.btoa(binary);
}

var orientationX = function (b64, callback) {
    var base64img = b64;
    var scanner = new DataView(fileReader.result);
    var idx = 0;
    var value = 1; // Non-rotated is the default
    if (fileReader.result.length < 2 || scanner.getUint16(idx) != 0xFFD8) {
        // Not a JPEG
        if (callback) {
            callback(base64img, value);
        }
        return;
    }
    idx += 2;
    var maxBytes = scanner.byteLength;
    while (idx < maxBytes - 2) {
        var uint16 = scanner.getUint16(idx);
        idx += 2;
        switch (uint16) {
            case 0xFFE1: // Start of EXIF
                var exifLength = scanner.getUint16(idx);
                maxBytes = exifLength - idx;
                idx += 2;
                break;
            case 0x0112: // Orientation tag
                // Read the value, its 6 bytes further out
                // See page 102 at the following URL
                // http://www.kodak.com/global/plugins/acrobat/en/service/digCam/exifStandard2.pdf
                value = scanner.getUint16(idx + 6, false);
                maxBytes = 0; // Stop scanning
                break;
        }
    }
    if (callback) {
        callback(base64img, value);
    }
};

function adjustOrientation(file, id) {
    orientationX(file, function (base64img, value) {
        var rotated = $('id').attr('src', base64img);
        if (value) {
            rotated.css('transform', rotation[value]);
        }
    });
}*/

function checkColor(check, data_photos){
    // Input: Si/No
    if (check.is_flag && !check.is_step && !check.is_expiration_date && !check.is_text && !check.is_number && !check.is_photo && !check.is_consumable) {
        if (check.value_flag === 1) {
            return 'green';
        } else if (check.value_flag === 0) {
            return 'red';
        }
    }
    // Input: Numero Libero
    if (!check.is_flag && !check.is_step && !check.is_expiration_date && !check.is_text &&
        check.is_number && !check.is_photo && !check.is_consumable) {
        return 'green';
    }
    // Input: Consumabile
    if (!check.is_flag && !check.is_step && !check.is_expiration_date && !check.is_text &&
        check.is_number && !check.is_photo && check.is_consumable) {
        if (check.value_number > check.number_error_at) {
            return 'green';
        } else if (check.value_number <= check.number_error_at) {
            return 'red';
        }
    }
    // Input: Consumabile + Data di Scadenza
    if (!check.is_flag && !check.is_step && check.is_expiration_date && !check.is_text && check.is_number && !check.is_photo && check.is_consumable) {
        if (check.value_number > check.number_error_at && check.value_flag === 1) {
            return 'green';
        } else {
            return 'red';
        }
    }
    // Input: Si/No + Livello
    if (check.is_flag && check.is_step && !check.is_expiration_date && !check.is_text && !check.is_number && !check.is_photo && !check.is_consumable) {
        if (check.value_flag === 1) {
            return 'green';
        } else if (check.value_flag === 0) {
            return 'red';
        }
    }
    // Input: Si/No + Data di Scadenza
    if (check.is_flag && !check.is_step && check.is_expiration_date && !check.is_text && !check.is_number && !check.is_photo && !check.is_consumable) {
        if (check.value_flag === 1) {
            return 'green';
        } else if (check.value_flag === 0) {
            return 'red';
        }
    }
    // Input: Si/No + Note
    if (check.is_flag && !check.is_step && !check.is_expiration_date && check.is_text && !check.is_number && !check.is_photo && !check.is_consumable) {
        if (check.value_flag === 1) {
            return 'green';
        } else if (check.value_flag === 0) {
            return 'red';
        }
    }
    // Input: Si/No + Upload Foto
    if (check.is_flag && !check.is_step && !check.is_expiration_date && !check.is_text && !check.is_number && check.is_photo && !check.is_consumable) {
        if (data_photos.length === 4) {
            return 'green';
        }
    }

    // Input: Note Libere
    if (!check.is_flag && !check.is_step && !check.is_expiration_date && check.is_text && !check.is_number && !check.is_photo && !check.is_consumable) {
        return 'green';
    }
    //In tutti gli altri casi di default è red!
    return 'red';
}
function checkNewColor(check){
    // Input: Si/No
    if (check.is_flag && !check.is_step && !check.is_expiration_date && !check.is_text && !check.is_number && !check.is_photo && !check.is_consumable) {
        if (check.new_value_flag === 1) {
            return 'green';
        } else if (check.new_value_flag === 0) {
            return 'red';
        }
    }
    // Input: Numero Libero
    if (!check.is_flag && !check.is_step && !check.is_expiration_date && !check.is_text &&
        check.is_number && !check.is_photo && !check.is_consumable) {
        return 'green';
    }
    // Input: Consumabile
    if (!check.is_flag && !check.is_step && !check.is_expiration_date && !check.is_text &&
        check.is_number && !check.is_photo && check.is_consumable) {
        if (check.new_value_number > check.number_error_at && check.new_value_number <= check.number_max) {
            return 'green';
        } else if (check.new_value_number <= check.number_error_at && check.new_value_number > check.number_max) {
            return 'red';
        }
    }
    // Input: Consumabile + Data di Scadenza
    if (!check.is_flag && !check.is_step && check.is_expiration_date && !check.is_text && check.is_number && !check.is_photo && check.is_consumable) {
        if (check.new_value_number > check.number_error_at && check.new_value_number <= check.number_max && check.new_value_flag === 1) {
            return 'green';
        } else {
            return 'red';
        }
    }
    // Input: Si/No + Livello
    if (check.is_flag && check.is_step && !check.is_expiration_date && !check.is_text && !check.is_number && !check.is_photo && !check.is_consumable) {
        if (check.new_value_flag === 1) {
            return 'green';
        } else if (check.new_value_flag === 0) {
            return 'red';
        }
    }
    // Input: Si/No + Data di Scadenza
    if (check.is_flag && !check.is_step && check.is_expiration_date && !check.is_text && !check.is_number && !check.is_photo && !check.is_consumable) {
        if (check.new_value_flag === 1) {
            return 'green';
        } else if (check.new_value_flag === 0) {
            return 'red';
        }
    }
    // Input: Si/No + Note
    if (check.is_flag && !check.is_step && !check.is_expiration_date && check.is_text && !check.is_number && !check.is_photo && !check.is_consumable) {
        if (check.new_value_flag === 1) {
            return 'green';
        } else if (check.new_value_flag === 0) {
            return 'red';
        }
    }
    // Input: Si/No + Upload Foto
    if (check.is_flag && !check.is_step && !check.is_expiration_date && !check.is_text && !check.is_number && check.is_photo && !check.is_consumable) {
        if (check.photos !== undefined) {
            if (check.photos.length === 4) {
                return 'green';
            }
        }
    }

    // Input: Note Libere
    if (!check.is_flag && !check.is_step && !check.is_expiration_date && check.is_text && !check.is_number && !check.is_photo && !check.is_consumable) {
        return 'green';
    }
    //In tutti gli altri casi di default è red!
    return 'red';
}
var server_addr = 'http://ceeqapi.com';
var ceeq_key = 'Basic dGVzdGVyOnRlc3Rlcg==';

/* Convert base64 to raw binary data held in a string in order to POST via ajax */
function dataURItoBlob(dataURI) {
    // doesn't handle URLEncoded DataURIs
    var binary = atob(dataURI.split(',')[1]);
    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]
    // write the bytes of the string to an array
    var array = [];
    for(var i = 0; i < binary.length; i++) {
        array.push(binary.charCodeAt(i));
    }
    // write the array to a blob
    return new Blob([new Uint8Array(array)], {type: mimeString});
}

/* Post photo to CeeQAPI (http://ceeqapi.com) for face detection; Face rect returned */
function upload(jq_element)
{
    //$('#loader_image').show();
    /*var blob = dataURItoBlob(upload_image);
    console.info(blob);
    var formData = new FormData();
    formData.append("fileupload",blob);
    console.info(formData);*/
    $.ajax( {
           url: server_addr + '/api/photos/',
           type: 'POST',
           data: {'photo_source_url':jq_element.attr('src')},
           headers: {'Authorization':ceeq_key},
           dataType: 'json',
           success: function( data )
           {
            console.info('success');
            console.info(data);
            for(var i=0;i<data.faces.length;i++){
                //draw face (optional; element may have to be passed in)
                var top = data.height*data.faces[i].face_tly;
                var left = data.width*data.faces[i].face_tlx;
                var width = data.width*data.faces[i].face_width;
                var height = data.height*data.faces[i].face_height;
                var stylestr = "height:"+height+"px;width:"+width+"px;top:"+top+"px;left:"+left+"px"
                jq_element.wrap('<div class="PhotoCell--photoWrapper"></div>');
                jq_element.parent().append('<div class="PhotoCell--tag" style="'+stylestr+';" data-face="'+data.faces[i].id+'"></div>');
                console.log(jq_element);
                /* Expecting something like this on the html side
                 <div class="PhotoCell--photoWrapper"><img src="' + upload_image + '" ></div>
                 .PhotoCell--tag {
                 position: absolute;
                 border: 2px solid rgba(255, 255, 255, 0.5);
                 }
                 .PhotoCell--photoWrapper {
                 position:absolute;
                 top:0;
                 bottom:0;
                 left:0;
                 right:0;
                 }
                 */
            }
            //$('#loader_image').hide();
           },
           error: function(data)
           {
            console.info('error');
            console.info(data);
            //$('#loader_image').hide();
           },
    } );
}


/* Hooks into html (assumes button called 'send_button') */
//send_button = document.getElementById('send_button');
//send_button.addEventListener("click", upload, true);
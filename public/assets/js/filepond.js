FilePond.registerPlugin(
    FilePondPluginImagePreview,
);

// Set default FilePond options
FilePond.setOptions({
    // upload to this server end point
    server: {

        process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {

            // fieldName is the name of the input field
            // file is the actual file object to send
            const formData = new FormData();
            formData.append(fieldName, file, file.name);

            const request = new XMLHttpRequest();
            request.open('POST', '/filepond/process');

            // Should call the progress method to update the progress to 100% before calling load
            // Setting computable to false switches the loading indicator to infinite mode
            request.upload.onprogress = (e) => {
                progress(e.lengthComputable, e.loaded, e.total);
            };

            // Should call the load method when done and pass the returned server file id
            // this server file id is then used later on when reverting or restoring a file
            // so your server knows which file to return without exposing that info to the client
            request.onload = function () {
                if (request.status >= 200 && request.status < 300) {
                    // the load method accepts either a string (id) or an object
                    load(request.responseText);
                    document.querySelector('input[name="cover"]').value = "/storage/" + request.responseText
                } else {
                    // Can call the error method if something is wrong, should exit after
                    error('oh no');
                }
            };

            request.send(formData);
        },
        revert: '/filepond/revert',
        restore: '/filepond/restore?id=',
        fetch: '/filepond/fetch?data=',
        load: '/filepond/load',
        fetch: '/filepond/fetch'
    },
});

const pond = FilePond.create(document.querySelector('input[type="file"]'));
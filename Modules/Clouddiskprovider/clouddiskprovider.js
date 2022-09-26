class CloudDiskProvider {
    setObservers() {
        const renameBnt = document.querySelectorAll('.js-rename');
        const downloadBnt = document.querySelectorAll('.js-download');
        const deleteBnt = document.querySelectorAll('.js-delete');

        renameBnt.forEach((button) => {
            button.addEventListener('click', () => {
                let item = button.closest('.disk-info-table-item');
                let input = item.querySelector('input');
                let path = item.getAttribute('data-path');
                let oldName = item.getAttribute('data-name');

                if (!button.classList.contains('active')) {
                    button.textContent = `Сохранить`;

                    input.removeAttribute('readonly');
                    input.focus();
                    button.classList.add('active');
                } else {
                    button.textContent = `Переименовать`;
                    button.classList.remove('active');
                    input.setAttribute('readonly', 'true');
                    //ajax
                    let newName = input.value;
                    if (newName != oldName) {
                        document.querySelector('.disk').innerHTML = "<div class=\"loader\"></div>";
                        const urlParams = new URLSearchParams(window.location.search);
                        let url = encodeURI('http://mysitelocal/?provider=yandex&action=rename&path=' + path + "&newName=" + newName + "&oldName=" + oldName + "&page=" + urlParams.get('page'));
                        let requestURL = new URL("", url);

                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', requestURL, false);
                        xhr.send();
                        document.querySelector('.disk').innerHTML = xhr.response;
                        this.setObservers();
                    }
                }
            });
        });

        downloadBnt.forEach((button) => {
            button.addEventListener('click', () => {
                let item = button.closest('.disk-info-table-item');
                let path = item.getAttribute('data-path');
                const urlParams = new URLSearchParams(window.location.search);
                let url = encodeURI('http://mysitelocal/?provider=yandex&action=download&path=' + path);
                let requestURL = new URL("", url);

                const xhr = new XMLHttpRequest();
                xhr.open('GET', requestURL, false);
                xhr.send();
                window.location.href = loadBinaryResource(xhr.response);
            });
        });

        deleteBnt.forEach((button) => {

        });
    }

}

function loadBinaryResource(url) {
    const req = new XMLHttpRequest();
    req.open("GET", url, false);
    req.overrideMimeType("text/plain; charset=x-user-defined");
    req.send(null);
    return req.status === 200 ? req.responseText : "";
}

export default CloudDiskProvider;
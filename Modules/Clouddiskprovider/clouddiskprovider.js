class CloudDiskProvider {
    setObservers() {
        const renameBnt = document.querySelectorAll('.js-rename');
        const downloadBnt = document.querySelectorAll('.js-download');
        const deleteBnt = document.querySelectorAll('.js-delete');
        const form = document.querySelector('.js-uploader');

        renameBnt.forEach((button) => {
            button.addEventListener('click', () => {
                let item = button.closest('.js-item');
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
                    let newName = input.value;
                    if (newName !== oldName) {
                        document.querySelector('.disk').innerHTML = "<div class=\"loader\"></div>";
                        let page = this.getCurrentPage();

                        const response = this.xhrRequest({
                            provider: 'yandex',
                            action: 'rename',
                            path: path,
                            page: page,
                            newName: newName,
                            oldName: oldName
                        });

                        document.querySelector('.disk').innerHTML = response;
                        this.setObservers();
                    }
                }
            });
        });

        downloadBnt.forEach((button) => {
            button.addEventListener('click', () => {
                let item = button.closest('.js-item');
                let path = item.getAttribute('data-path');

                const response = this.xhrRequest({
                    provider: 'yandex',
                    action: 'download',
                    path: path
                });

                let link = document.createElement('a');
                link.setAttribute('href', response);
                link.setAttribute('download', response);
                link.click();
            });
        });

        deleteBnt.forEach((button) => {
            button.addEventListener('click', () => {
                let item = button.closest('.js-item');
                let path = item.getAttribute('data-path');
                let page = this.getCurrentPage();

                const response = this.xhrRequest({
                    provider: 'yandex',
                    action: 'delete',
                    path: path,
                    page: page
                });

                document.querySelector('.disk').innerHTML = response;
                this.setObservers();
            });
        });

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const fileInput = document.querySelector('.js-file');
            const file = fileInput.files[0];
            if (!this.validateFile(file)) {
                document.querySelector('.js-res-upload').textContent = "Ошибка, приложен некорректный файл!";
                return false;
            }
            let formData = new FormData();
            formData.append('file', fileInput.files[0]);
            formData.append('action', 'load');
            formData.append('page', this.getCurrentPage());
            formData.append('provider', 'yandex');
            document.querySelector('.disk').innerHTML = "<div class=\"loader\"></div>";
            const response = this.xhrRequestFile(formData);
        });
    }

    validateFile(file) {
        if(file == undefined)
            return false;
        if (file.size > 10000000)
            return false;
        if (file.type == "application/x-shellscript" || file.type == "application/x-ms-dos-executable") {
            return false;
        }
        return true;
    }

    getCurrentPage() {
        const urlParams = new URLSearchParams(window.location.search);
        let page = urlParams.get('page');
        if (page == null) page = 1;
        return page;
    }

    xhrRequestFile(send) {
        let url = 'http://mysitelocal/';
        const xhr = new XMLHttpRequest();
        let requestURL = new URL("", url);
        xhr.open('POST', requestURL);
        xhr.send(send);
        xhr.onreadystatechange = this.callback()
    }

    callback(x, m) {
        return function () {
            if (this.readyState == 4 && this.status == 200) {
                document.querySelector('.disk').innerHTML = this.response;
                (new CloudDiskProvider).setObservers();
                document.querySelector('.js-res-upload').textContent = "Файл успешно загружен!";
            }
        };
    }

    xhrRequest(params, send = null) {
        let url = 'http://mysitelocal/?';
        for (let key in params) {
            url = url + "&" + key + "=" + params[key];
        }
        const xhr = new XMLHttpRequest();
        let requestURL = new URL("", url);
        xhr.open('GET', requestURL, false);
        xhr.send(send);
        return xhr.response;
    }
}

export default CloudDiskProvider;
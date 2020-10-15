window.onload = function() {
    let links = document.querySelectorAll("[data-delete]");

    for (link of links) {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            if (confirm('Voulez-vous supprimer cet élément ?')) {
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    response => response.json()
                ).then(data => {
                        if (data.success) {
                            if (this.id === 'application_delete') {
                                this.parentElement.parentElement.parentElement.parentElement.remove();
                            } else {
                                this.parentElement.remove();
                            }
                        } else
                            alert(data.error);
                    }
                ).catch(e => alert(e))
            }
        })
    }
};

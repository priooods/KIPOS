function approvalemkls() {
    return {
        popup: 0,
        sementara: {},
        showLoading: false,
        details_table: {},
        list_details_table: [],
        init() {
            // this.getDetailsGto();
        },
        openPopupVerif(item) {
            return (this.sementara = item), (this.popup = 1);
        },
        openPopupReject(item) {
            return (this.sementara = item), (this.popup = 2);
        },
        cancel() {
            return (this.sementara = {}), (this.popup = 0);
        },
        Approved() {
            this.showLoading = true;
            this.popup = 0;
            fetch("/emkls_verif", {
                method: "post",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: JSON.stringify(this.sementara),
            })
                .then((res) => res.json())
                .then((e) => {
                    console.log(e);
                    // if (e.error_code)
                        // console.log(e);
                        return (this.showLoading = false), this.getDetailsGto();
                });
        },
        Rejected() {
            this.showLoading = true;
            this.popup = 0;
            fetch("/emkls_reject", {
                method: "post",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: JSON.stringify(this.sementara),
            })
                .then((res) => res.json())
                .then((e) => {
                    // if (e.error_code)
                        // console.log(e);
                        return (this.showLoading = false), this.getDetailsGto();
                });
        },
        getDetailsGto() {
            return window.location.reload;
        },
    };
}

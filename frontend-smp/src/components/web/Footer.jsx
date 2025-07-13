import React from "react";

export default function footer() {
  return (
    <footer>
      <div className="container-fluid footer-top">
        <div className="row p-4">
          <div className="col-md-4 mb-4 mt-3">
            <h5>
              TENTANG
              <strong style={{ color: "#ffd22e" }}> SMP UISU</strong>
            </h5>
            <hr />
            <div className="text-center">
              <img src="/images/logostikom.png" width="70" />
            </div>
            <p className="text-justify mt-3">
              SMP Swasta Islam Proyek UISU Siantar merupakan salah satu Sekolah 
              Yang berada di Kabupaten Simalungun. Yang memiliki Lokasi Strategis.
            </p>
          </div>
          <div className="col-md-4 mb-4 mt-3">
            <h5>
              DOWNLOAD <strong style={{ color: "#ffd22e" }}> APLIKASI</strong>
            </h5>
            <hr />
            <div className="text-left">
              <img
                src="/images/playstore.png"
                width={"180"}
                className="text-center align-items-center"
              />
            </div>
            <p className="text-justify mt-2 text-left">
              Dapatkan info update Sekolah lebih cepat melalui aplikasi Android.
              Silahkan unduh melalui PlayStore.
            </p>
          </div>
          <div className="col-md-4 mb-4 mt-3">
            <h5>
              KONTAK <strong style={{ color: "#ffd22e" }}>KAMI</strong>
            </h5>
            <hr />
            <p>
              <i className="fa fa-map-marker"></i> Jln. Asahan Km. 4.5,
              Siantar Estate, Simalungun, Sumatera Utara, 21151
              <br />
              <br />
              <i className="fas fa-envelope"></i> anbianuansyah@gmail.com
              <br />
              <br />
              <i className="fas fa-phone"></i> +62 812-7553-1234
            </p>
          </div>
        </div>
      </div>
      <div className="container-fluid footer-bottom">
        <div className="row p-3">
          <div className="text-center text-white font-weight-bold">
            Copyright © 2025 SMP UISU Siantar. All Rights Reserved.
          </div>
        </div>
      </div>
    </footer>
  );
}
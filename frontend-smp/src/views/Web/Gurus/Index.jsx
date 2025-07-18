import React, { useState, useEffect } from "react";

//import layout web
import LayoutWeb from "../../../layouts/Web";

//import service api
import Api from "../../../services/Api";

//import component alert
import AlertDataEmpty from "../../../components/general/AlertDataEmpty";

//import component loading
import Loading from "../../../components/general/Loading";

//import component card guru
import CardGuru from "../../../components/general/CardGuru";

export default function Gurus() {
  //title page
  document.title = "Guru - SMP UISU";

  //init state
  const [gurus, setGurus] = useState([]);
  const [loadingGuru, setLoadingGuru] = useState(true);

  //fetch data gurus
  const fetchDataGurus = async () => {
    //setLoadingGuru "true"
    setLoadingGuru(true);

    //fetch data
    await Api.get("/api/public/gurus").then((response) => {
      //assign response to state "gurus"
      setGurus(response.data.data);

      //setLoadingGuru "false"
      setLoadingGuru(false);
    });
  };

  //hook useEffect
  useEffect(() => {
    //call method "fetchDataGurus"
    fetchDataGurus();
  }, []);

  return (
    <LayoutWeb>
      <div className="container mt-4 mb-3">
        <div classname="row">
          <div className="col-md-12">
            <h5 className="text-uppercase">
              <i className="fa fa-user-circle"></i> Guru Sekolah
            </h5>
            <hr />
          </div>
        </div>
        <div className="row mt-4">
          {loadingGuru ? (
            <Loading />
          ) : gurus.length > 0 ? (
            gurus.map((guru) => (
              <CardGuru
                key={guru.id}
                name={guru.name}
                image={guru.image}
                role={guru.role}
              />
            ))
          ) : (
            <AlertDataEmpty />
          )}
        </div>
      </div>
    </LayoutWeb>
  );
}
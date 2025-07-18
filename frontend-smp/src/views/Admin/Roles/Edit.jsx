//import react
import { useState, useEffect } from "react";

//import react router dom
import { Link, useNavigate, useParams } from "react-router-dom";

//import layout
import LayoutAdmin from "../../../layouts/Admin";

//import api
import Api from "../../../services/Api";

//import js cookie
import Cookies from "js-cookie";

//import toast
import toast from "react-hot-toast";

export default function RolesEdit() {
  //title page
  document.title = "Edit Role - SMP Digital";

  //navigata
  const navigate = useNavigate();

  //get ID from parameter URL
  const { id } = useParams();

  //define state for form
  const [name, setName] = useState("");
  const [permissionsData, setPermissionsData] = useState([]);
  const [errors, setErros] = useState([]);

  //define state "permissions"
  const [permissions, setPermissions] = useState([]);

  //token from cookies
  const token = Cookies.get("token");

  //function "fetchDataPermissions"
  const fetchDataPermissions = async () => {
    await Api.get("/api/admin/permissions/all", {
      //header
      headers: {
        //header Bearer + Token
        Authorization: `Bearer ${token}`,
      },
    }).then((response) => {
      //set response data to state "permissions"
      setPermissions(response.data.data);
    });
  };

  //function "fetchDataRole"
  const fetchDataRole = async () => {
    await Api.get(`/api/admin/roles/${id}`, {
      //header
      headers: {
        //header Bearer + Token
        Authorization: `Bearer ${token}`,
      },
    }).then((response) => {
      //set response data to state
      setName(response.data.data.name);
      setPermissionsData(response.data.data.permissions.map((obj) => obj.name));
    });
  };

  //useEffect
  useEffect(() => {
    //call function "fetchDataPermissions"
    fetchDataPermissions();

    //call function "fetchDataRole"
    fetchDataRole();
  }, []);

  //define function "handleCheckboxChange"
  const handleCheckboxChange = (e) => {
    //define data
    let data = permissionsData;

    //check item already exists, if so, remove with filter
    if (data.some((name) => name === e.target.value)) {
      data = data.filter((name) => name !== e.target.value);
    } else {
      //push new item to array
      data.push(e.target.value);
    }

    //set data to state
    setPermissionsData(data);
  };

  //function "updateRole"
  const updateRole = async (e) => {
    e.preventDefault();

    //sending data
    await Api.post(
      `/api/admin/roles/${id}`,
      {
        //data
        name: name,
        permissions: permissionsData,
        _method: "PUT",
      },
      {
        //header
        headers: {
          //header Bearer + Token
          Authorization: `Bearer ${token}`,
        },
      }
    )
      .then((response) => {
        //show toast
        toast.success(response.data.message, {
          position: "top-right",
          duration: 4000,
        });

        //redirect
        navigate("/admin/roles");
      })
      .catch((error) => {
        //set error message to state "errors"
        setErros(error.response.data);
      });
  };

  return (
    <LayoutAdmin>
      <main>
        <div className="container-fluid mb-5 mt-5">
          <div className="row">
            <div className="col-md-12">
              <Link
                to="/roles"
                className="btn btn-md btn-primary border-0 shadow-sm mb-3"
                type="button"
              >
                <i className="fa fa-long-arrow-alt-left me-2"></i> Back
              </Link>
              <div className="card border-0 rounded shadow-sm border-top-success">
                <div className="card-body">
                  <h6>
                    <i className="fa fa-shield-alt"></i> Edit Role
                  </h6>
                  <hr />
                  <form onSubmit={updateRole}>
                    <div className="mb-3">
                      <label className="form-label fw-bold">Role Name</label>
                      <input
                        type="text"
                        className="form-control"
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                        placeholder="Enter Role Name"
                      />
                    </div>
                    {errors.name && (
                      <div className="alert alert-danger">{errors.name[0]}</div>
                    )}
                    <hr />
                    <div className="mb-3">
                      <label className="fw-bold">Permissions</label>
                      <br />
                      {permissions.map((permission) => (
                        <div
                          className="form-check form-check-inline"
                          key={Math.random()}
                        >
                          <input
                            className="form-check-input"
                            type="checkbox"
                            value={permission.name}
                            defaultChecked={permissionsData.some(
                              (name) => name === permission.name ?? true
                            )}
                            onChange={handleCheckboxChange}
                            id={`check-${permission.id}`}
                          />
                          <label
                            className="form-check-label fw-normal"
                            htmlFor={`check-${permission.id}`}
                          >
                            {permission.name}
                          </label>
                        </div>
                      ))}

                      {errors.permissions && (
                        <div className="alert alert-danger mt-2">
                          {errors.permissions[0]}
                        </div>
                      )}
                    </div>
                    <div>
                      <button
                        type="submit"
                        className="btn btn-md btn-primary me-2"
                      >
                        <i className="fa fa-save"></i> Update
                      </button>
                      <button type="reset" className="btn btn-md btn-warning">
                        <i className="fa fa-redo"></i> Reset
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </LayoutAdmin>
  );
}
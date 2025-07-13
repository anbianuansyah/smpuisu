//import hook
import { useState, useEffect } from "react";

//import layout
import LayoutAdmin from "../../../layouts/Admin";

//import service api
import Api from "../../../services/Api";

//import js cookie
import Cookies from "js-cookie";

//import Link
import { Link } from "react-router-dom";

export default function Dashboard() {
  //title page
  document.title = "Dashboard - SMP Digital";

  //init state
  const [countCategories, setCountCategories] = useState(0);
  const [countPosts, setCountPosts] = useState(0);
  const [countProducts, setCountProducts] = useState(0);
  const [countGurus, setCountGurus] = useState(0);

  //token from cookies
  const token = Cookies.get("token");

  //hook useEffect
  useEffect(() => {
    //fetch api
    Api.get("/api/admin/dashboard", {
      //header
      headers: {
        //header Bearer + Token
        Authorization: `Bearer ${token}`,
      },
    }).then((response) => {
      //set data
      setCountCategories(response.data.data.categories);
      setCountPosts(response.data.data.posts);
      setCountProducts(response.data.data.products);
      setCountGurus(response.data.data.gurus);
    });
  }, []);

  return (
    <LayoutAdmin>
      <main>
        <div class="container-fluid px-4 mt-5">
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card bg-primary text-white mb-4 border-0 shadow-sm">
                <div class="card-body">
                  <strong>{countCategories}</strong> CATEGORIES
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <Link
                    class="small text-white stretched-link"
                    to="/admin/categories"
                  >
                    View Details
                  </Link>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card bg-warning text-white mb-4 border-0 shadow-sm">
                <div class="card-body">
                  <strong>{countPosts}</strong> POSTS
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <Link
                    class="small text-white stretched-link"
                    to="/admin/posts"
                  >
                    View Details
                  </Link>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card bg-success text-white mb-4 border-0 shadow-sm">
                <div class="card-body">
                  <strong>{countProducts}</strong> PRODUCTS
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <Link
                    class="small text-white stretched-link"
                    to="/admin/products"
                  >
                    View Details
                  </Link>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card bg-danger text-white mb-4 border-0 shadow-sm">
                <div class="card-body">
                  <strong>{countGurus}</strong> GURU
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <Link
                    class="small text-white stretched-link"
                    to="/admin/gurus"
                  >
                    View Details
                  </Link>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </LayoutAdmin>
  );
}
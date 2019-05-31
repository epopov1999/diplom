<?php

class FormController extends Controller 
{
    
    public function auth() {
            include('forms/auth.html');
    }

    public function createProduct() {
        
        if ($this->isAdmin()) {
            include('forms/form_product_create.html');
        }else{
            include('forms/auth.html');
        }
    }
    
    public function editProduct() {
        
        if ($this->isAdmin()) {
            include('forms/form_product_edit.html');
        }else{
            include('forms/auth.html');
        }
    }

    public function deleteProduct() {
        
        if ($this->isAdmin()) {
            include('forms/form_product_delete.html');
        }else{
            include('forms/auth.html');
        }
    }

    public function createCategory() {
        
        if ($this->isAdmin()) {
            include('forms/form_category_create.html');
        }else{
            include('forms/auth.html');
        }
    }

    public function editCategory() {
        
        if ($this->isAdmin()) {
            include('forms/form_category_edit.html');
        }else{
            include('forms/auth.html');
        }
    }

    public function deleteCategory() {
        
        if ($this->isAdmin()) {
            include('forms/form_category_delete.html');
        }else{
            include('forms/auth.html');
        }
    }
}
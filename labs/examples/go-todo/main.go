package main

import (
	"errors"
	"html/template"
	"log/slog"
	"net/http"

	"gorm.io/driver/sqlite"
	"gorm.io/gorm"
)

type Item struct {
	gorm.Model
	Title       string
	Description string
}

type server struct {
	db *gorm.DB
}

func (s *server) handleCreateItem(w http.ResponseWriter, r *http.Request) {
	itemTitle := r.PostFormValue("title")
	itemDesc := r.PostFormValue("description")

	if itemTitle != "" {
		s.db.Create(&Item{Title: itemTitle, Description: itemDesc})
	}

	http.Redirect(w, r, "/", http.StatusFound)
}

func (s *server) handleCreateItemForm(w http.ResponseWriter, r *http.Request) {
	t, _ := template.ParseFiles("templates/base.html", "templates/item_create.html")
	t.ExecuteTemplate(w, "base", nil)
}

func (s *server) handleGetItem(w http.ResponseWriter, r *http.Request) {
	itemID := r.PathValue("id")

	var item Item
	err := s.db.First(&item, "id = ?", itemID).Error

	if errors.Is(err, gorm.ErrRecordNotFound) {
		http.Redirect(w, r, "/", http.StatusSeeOther)
	}

	t, _ := template.ParseFiles("templates/base.html", "templates/item_show.html")
	t.ExecuteTemplate(w, "base", item)
}

func (s *server) handleDeleteItem(w http.ResponseWriter, r *http.Request) {
	itemID := r.PathValue("id")

	var item Item
	err := s.db.First(&item, "id = ?", itemID).Error

	if errors.Is(err, gorm.ErrRecordNotFound) {
		http.Redirect(w, r, "/", http.StatusSeeOther)
	}

	s.db.Delete(&Item{}, itemID)

	http.Redirect(w, r, "/", http.StatusFound)
}

func (s *server) handleGetAllItems(w http.ResponseWriter, r *http.Request) {
	var items []Item
	s.db.Find(&items)

	t, _ := template.ParseFiles("templates/base.html", "templates/index.html")
	t.ExecuteTemplate(w, "base", items)
}

func main() {
	const bindAddr string = ":5001"

	db, err := gorm.Open(sqlite.Open("db.sqlite"), &gorm.Config{})
	db.AutoMigrate(&Item{})

	if err != nil {
		slog.Error(err.Error())
	}

	s := server{db: db}

	mux := http.NewServeMux()

	mux.HandleFunc("POST /todo/new", s.handleCreateItem)
	mux.HandleFunc("GET /todo/new", s.handleCreateItemForm)
	mux.HandleFunc("POST /todo/delete/{id}", s.handleDeleteItem)
	mux.HandleFunc("GET /todo/{id}", s.handleGetItem)
	mux.HandleFunc("GET /todo/all", s.handleGetAllItems)
	mux.HandleFunc("GET /", s.handleGetAllItems)

	fs := http.FileServer(http.Dir("./static"))
	mux.Handle("GET /static/", http.StripPrefix("/static/", fs))

	slog.Info("Running on", "address", bindAddr)
	http.ListenAndServe(bindAddr, mux)
}

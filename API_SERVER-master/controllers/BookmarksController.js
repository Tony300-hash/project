const Repository = require('../models/Repository');
const url = require('url');

module.exports =
class BookmarksController extends require('./Controller') {
	constructor(req, res){
        super(req, res);
        this.bookmarksRepository = new Repository('bookmarks');
    }
	get(id){
		let resultat = undefined;
		const reqUrl =  url.parse(this.req.url, true);
		console.log(reqUrl);
		//GET /api/bookmarks/id 
		if(!isNaN(id)){
			resultat = this.bookmarksRepository.get(id);
		} 
		else{
			//GET /api/bookmarks
			resultat = this.bookmarksRepository.getAll();
		}     
		if(reqUrl.query.sort != undefined){
			//GET /api/bookmarks?sort="name"
			if(reqUrl.query.sort =="name"){
				resultat = this.bookmarksRepository.getAll();
				resultat.sort(function compare( a, b ){
					if ( a.Name < b.Name ){return -1;}
					if ( a.Name > b.Name ){return 1;}
					return 0;
				});	
			}	
			//GET /api/bookmarks?sort="category"		
			if(reqUrl.query.sort =="category"){				
				resultat = this.bookmarksRepository.getAll();
				resultat.sort(function compare( a, b ){
					if ( a.Category < b.Category ){return -1;}
					if ( a.Category > b.Category ){return 1;}
					return 0;
				});	
			}	
		}		
		if(reqUrl.query.name != undefined){
			if(reqUrl.query.name.endsWith("*")){
				//GET /api/bookmarks?name="ab*" 
				resultat = this.bookmarksRepository.getByNameSearch(reqUrl.query.name);
			}
			else{ 
				//GET /api/bookmark?name="nom" 
				resultat = this.bookmarksRepository.getByName(reqUrl.query.name); 
			} 
			
		}	
		if(reqUrl.query.category != undefined){
			//GET /api/bookmarks?category="sport" 
			resultat = this.bookmarksRepository.getByCategorie(reqUrl.query.category);
		}
		if(reqUrl.search == '?'){
			resultat = this.bookmarksRepository.getInfoCommande();
		}
		this.response.JSON(resultat);
    }
	//POST /api/bookmarks
	post(bookmark){
		if(!this.bookmarksRepository.checkValueNull(bookmark)){
			let newBookmark = this.bookmarksRepository.add(bookmark);
        	if (newBookmark)
            	this.response.created(newBookmark);
        	else
            	this.response.internalError();
		}
		else{
			console.log("Vous ne pouvez pas mettre de valeur null"); 
		}
		      
    }	
	//PUT /api/bookmarks/id 
	put(bookmark){ 
		if(!this.bookmarksRepository.checkValueNull(bookmark)){
			if (this.bookmarksRepository.update(bookmark))
				this.response.ok();
			else 
				this.response.notFound();
		}
		else{
			console.log("Vous ne pouvez pas mettre de valeur null");
		}			
    }
	//DELETE /api/bookmarks/id 
	remove(id){
        if (this.bookmarksRepository.remove(id))
            this.response.accepted();
        else
            this.response.notFound();
	}
	
}

const fs = require('fs');
///////////////////////////////////////////////////////////////////////////
// This class provide CRUD operations on JSON objects collection text file 
// with the assumption that each object have an Id member.
// If the objectsFile does not exist it will be created on demand.
// Warning: no type and data validation is provided
///////////////////////////////////////////////////////////////////////////
module.exports = 
class Repository {
    constructor(objectsName) {
        objectsName = objectsName.toLowerCase();
        this.objectsMenus =[{
            "GET":"api/bookmarks endpoint",
            "Titre":"La liste des paramètres supportés:",
            "Option1":"? sort = name",
            "Option2":"? sort = category",
            "Option3":"/ id",
            "Option4":"? name = string",
            "Option5":"? name = string*",
            "Option6":"? category = string",
        }];
        this.objectsList = [];
        this.objectsFile = `./data/${objectsName}.json`;
        this.read();
    }
    read() {
        try{
            // Here we use the synchronus version readFile in order  
            // to avoid concurrency problems
            let rawdata = fs.readFileSync(this.objectsFile);
            // we assume here that the json data is formatted correctly
            this.objectsList = JSON.parse(rawdata);
        } catch(error) {
            if (error.code === 'ENOENT') {
                // file does not exist, it will be created on demand
                this.objectsList = [];
            }
        }
    }
    write() {
        // Here we use the synchronus version writeFile in order
        // to avoid concurrency problems  
        fs.writeFileSync(this.objectsFile, JSON.stringify(this.objectsList));
        this.read();
    }
    nextId() {
        let maxId = 0;
        for(let object of this.objectsList){
            if (object.Id > maxId) {
                maxId = object.Id;
            }
        }
        return maxId + 1;
    }
    add(object) {
        try {
            object.Id = this.nextId();
            this.objectsList.push(object);
            this.write();
            return object;
        } catch(error) {
            return null;
        }
    }
    getAll() {
        return this.objectsList;
    }
    get(id){
        for(let object of this.objectsList){
            if (object.Id === id) {
               return object;
            }
        }
        return null;
    }
	getByName(name){
        let tab = []
        let compteur = 0
        for(let object of this.objectsList){
            if (object.Name === name) {
               tab[compteur] = object;
               ++compteur;
            }
        }
        return tab;
    }
    getByNameSearch(name){
        let tab = []
        let compteur = 0
        name = name.replace("*", "");
        for(let object of this.objectsList){
            if (object.Name.startsWith(name)) {
               tab[compteur] = object;
               ++compteur;
            }
        }
        return tab;
    }
	getByCategorie(cat){
        let tab = []
        let compteur = 0
        for(let object of this.objectsList){
            if (object.Category === cat) {
                tab[compteur] = object;
                ++compteur;
            }
        }
        return tab;
    }
    remove(id) {
        let index = 0;
        for(let object of this.objectsList){
            if (object.Id === id) {
                this.objectsList.splice(index,1);
                this.write();
                return true;
            }
            index ++;
        }
        return false;
    }
    update(objectToModify) {
        let index = 0;
        for(let object of this.objectsList){
            if (object.Id === objectToModify.Id) {
                this.objectsList[index] = objectToModify;
                this.write();
                return true;
            }
            index ++;
        }
        return false;
    }
    getInfoCommande()
    {
        return this.objectsMenus;
    }
    checkValueNull(bookmarks)
    {
        if(bookmarks.Name != null && bookmarks.Url !=null && bookmarks.Category !=null )
        {
            return false;
        }
        return true;
    }

    
    
}
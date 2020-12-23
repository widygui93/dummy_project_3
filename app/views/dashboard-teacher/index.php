<main class="dashboard-teacher">
    <div class="row-header">
        <h3>Upload Your Tutorial</h3>
    </div>
    <div class="tutorial-form">
        <form action="<?= BASEURL; ?>/Dashboard_teacher/upload" method="post" autocomplete="off">
            <div class="form-group">
                <label for="title">Title</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    
                    class="form-control" 
                    placeholder="title" 
                    autocomplete="off"
                    required
                >
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select name="level" id="level">
                    <option value="all-level">All Level</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advance">Advance</option>
                </select>
            </div>
            <div class="form-group">
                <label for="prize">Prize</label>
                <input 
                    type="text" 
                    name="prize" 
                    id="prize" 
                    
                    class="form-control" 
                    placeholder="prize" 
                    autocomplete="off"
                    required
                >
            </div>
            <div class="form-group">
                <label for="desc">Description</label>
                <textarea id="desc" name="desc" placeholder="Description..." required></textarea>
            </div>
            <div class="form-group">
                <label for="video">Upload Video</label>
                <input type="file" name="video" id="video" class="form-control" required>
                <img style="width:100px; height:100px;" id="blah" src="#" alt="your image" />
            </div>
            <div class="form-group">
                <label for="img-cover">Upload image cover</label>
                <input type="file" name="img-cover" id="img-cover" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" name="upload" class="btn btn-outline-dark">Upload</button>
            </div>
        </form>
    </div>
    <div class="tutorial-display">
    </div>
</main>
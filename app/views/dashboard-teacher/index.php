<main class="dashboard-teacher">
	<?php Flasher::flash();  ?>
    <div class="row-header">
        <h3>Upload Your Tutorial</h3>
    </div>
    <div class="tutorial-form">
        <form action="<?= BASEURL; ?>/Dashboard_teacher/upload" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group item-title">
                <label for="title">Title</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    minlength="6" 
                    maxlength="50"
                    pattern="^[a-zA-Z0-9 .,\-&]*$"
                    class="form-control" 
                    placeholder="Your tutorial title" 
                    autocomplete="off"
                    required
                >
            </div>
            <div class="form-group item-level">
                <label for="level">Level</label>
                <select name="level" id="level">
                    <option value="all_level">All Level</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advance">Advance</option>
                </select>
            </div>
            <div class="form-group item-prize">
                <label for="prize">Prize</label>
                <input 
                    type="text" 
                    name="prize" 
                    id="prize" 
                    pattern="^[0-9]*$"
                    class="form-control" 
                    placeholder="0" 
                    autocomplete="off"
                    required
                >
            </div>
            <div class="form-group item-desc">
                <label for="desc">Description</label>
                <textarea 
                    id="desc"
                    name="desc"
                    minlength="10"
                    maxlength="300"
                    placeholder="Description..."
                    required></textarea>
            </div>
            <div class="form-group item-vid">
                <label for="video">Upload Video</label>
                <input type="file" name="video" id="video" class="form-control" required>
                <video poster="<?= BASEURL; ?>/img/default-video.png">
                    <source id="vid-src" src="#" type="video/webm" />
                    Your Browser is not supported.
                </video>
            </div>
            <div class="form-group item-img-cover">
                <label for="img-cover">Upload image cover</label>
                <input type="file" name="img-cover" id="img-cover-input" class="form-control" required>
                <img id="img-cover" src="<?= BASEURL; ?>/img/default-img.jpg" />
            </div>
            <div class="form-group item-subtitle">
                <label for="subtitle">Upload subtitle (Optional)</label>
                <input type="file" name="subtitle" id="subtitle-input" class="form-control">
            </div>
            <div class="form-group item-btn">
                <button type="submit" name="upload" class="btn btn-outline-dark">Upload</button>
            </div>
        </form>
    </div>
    <div class="row-header">
        <h3>Your Tutorial</h3>
    </div>
    
</main>
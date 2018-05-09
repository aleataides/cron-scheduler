<div class="col-md-12">
    <div class="col-middle">
        <div class="text-center">
            <h1 class="error-number">{{ auth()->user()->name }}</h1>
            <h2>Screen locked</h2>
            <p>Enter your password below to unlock screen.</p>
            <div class="mid_center">
                <h3>Search</h3>
                <form>
                    <div class="col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Enter password to unlock">
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button">Unlock!</button>
                          </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
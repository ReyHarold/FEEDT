<script src="https://kit.fontawesome.com/1fc4ea1c6a.js"></script>
  <div class="box">
            <h2>All Activities</h2>
            
         <div class="search-box">
            <button class="btn-search"><i class="fas fa-search"></i></button>
            <input type="text" class="input-search" placeholder="Type to Search...">
        </div></div>

</div> 
<style>
.box {
    width: 100%;
    background-color: #628338;
    padding: 40px;
    border-radius: 5px;
    margin: 15px 0;
    box-shadow: 5px 10px 20px 5px black;
}
.search-box{
        width: fit-content;
        height: fit-content;
        position: relative;
      }
      .input-search{
        height: 50px;
        width: 50px;
        border-style: none;
        padding: 10px;
        font-size: 18px;
        letter-spacing: 2px;
        outline: none;
        border-radius: 50%;
        transition: all 500ms ease-in-out;
        background-color: #22a6b3;
        padding-right: 40px;
        color:#fff;
      }
      .input-search::placeholder{
        color:rgba(255,255,255,.5);
        font-size: 18px;
        letter-spacing: 2px;
        font-weight: 100;
      }
      .btn-search{
        width: 50px;
        height: 50px;
        border-style: none;
        font-size: 20px;
        outline: none;
        cursor: pointer;
        border-radius: 50%;
        position: absolute;
        right: 0px;
        color:#ffffff ;
        background-color:transparent; 
      }
      .btn-search:focus ~ .input-search{
        width: 300px;
        border-radius: 0px;
        background-color: transparent;
        border-bottom:1px solid rgba(255,255,255,.5);
        transition: all 500ms cubic-bezier(0, 0.110, 0.35, 2);
      }
      .input-search:focus{
        width: 300px;
        border-radius: 0px;
        background-color: transparent;
        border-bottom:1px solid rgba(255,255,255,.5);
        transition: all 500ms cubic-bezier(0, 0.110, 0.35, 2);

</style>
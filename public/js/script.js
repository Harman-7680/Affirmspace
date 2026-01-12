// // On page load or when changing themes, best to add inline in `head` to avoid FOUC
// if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
//     document.documentElement.classList.add('dark')
//     } else {
//     document.documentElement.classList.remove('dark')
//     }

// // Whenever the user explicitly chooses light mode
// localStorage.theme = 'light'

// // Whenever the user explicitly chooses dark mode
// localStorage.theme = 'dark'

// // Whenever the user explicitly chooses to respect the OS preference
// localStorage.removeItem('theme')



// // add post upload image 
// document.getElementById('addPostUrl').addEventListener('change', function(){
// if (this.files[0] ) {
//     var picture = new FileReader();
//     picture.readAsDataURL(this.files[0]);
//     picture.addEventListener('load', function(event) {
//     document.getElementById('addPostImage').setAttribute('src', event.target.result);
//     document.getElementById('addPostImage').style.display = 'block';
//     });
// }
// });


// // Create Status upload image 
// document.getElementById('createStatusUrl').addEventListener('change', function(){
// if (this.files[0] ) {
//     var picture = new FileReader();
//     picture.readAsDataURL(this.files[0]);
//     picture.addEventListener('load', function(event) {
//     document.getElementById('createStatusImage').setAttribute('src', event.target.result);
//     document.getElementById('createStatusImage').style.display = 'block';
//     });
// }
// });


// // create product upload image
// document.getElementById('createProductUrl').addEventListener('change', function(){
// if (this.files[0] ) {
//     var picture = new FileReader();
//     picture.readAsDataURL(this.files[0]);
//     picture.addEventListener('load', function(event) {
//     document.getElementById('createProductImage').setAttribute('src', event.target.result);
//     document.getElementById('createProductImage').style.display = 'block';
//     });
// }
// });




// Dark mode toggle based on localStorage or OS preference
if (
  localStorage.theme === 'dark' ||
  (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
) {
  document.documentElement.classList.add('dark');
} else {
  document.documentElement.classList.remove('dark');
}

// Remove these if not used right away or bind to UI
// localStorage.theme = 'light'
// localStorage.theme = 'dark'
// localStorage.removeItem('theme')

// Safe DOM access
document.addEventListener('DOMContentLoaded', () => {
  // Add Post Upload
  const addPostUrl = document.getElementById('addPostUrl');
  const addPostImage = document.getElementById('addPostImage');
  if (addPostUrl && addPostImage) {
    addPostUrl.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const picture = new FileReader();
        picture.readAsDataURL(this.files[0]);
        picture.addEventListener('load', function (event) {
          addPostImage.setAttribute('src', event.target.result);
          addPostImage.style.display = 'block';
        });
      }
    });
  }

  // Create Status Upload
  const createStatusUrl = document.getElementById('createStatusUrl');
  const createStatusImage = document.getElementById('createStatusImage');
  if (createStatusUrl && createStatusImage) {
    createStatusUrl.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const picture = new FileReader();
        picture.readAsDataURL(this.files[0]);
        picture.addEventListener('load', function (event) {
          createStatusImage.setAttribute('src', event.target.result);
          createStatusImage.style.display = 'block';
        });
      }
    });
  }

  // Create Product Upload
  const createProductUrl = document.getElementById('createProductUrl');
  const createProductImage = document.getElementById('createProductImage');
  if (createProductUrl && createProductImage) {
    createProductUrl.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const picture = new FileReader();
        picture.readAsDataURL(this.files[0]);
        picture.addEventListener('load', function (event) {
          createProductImage.setAttribute('src', event.target.result);
          createProductImage.style.display = 'block';
        });
      }
    });
  }
});



    
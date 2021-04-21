## PicoDownloadList

PicoDownloadList is a PicoCMS plugin that, given a folder, creates a list of all files inside it with links for downloading each file.

### Installation

Clone this project into the PicoCMS plugins folder.

### Usage

To create a download list for a given folder, insert the shortcode `[download FOLDER]` in a page and replace `FOLDER` with a folder of your choice. If the plugin is enabled and the folder exists inside your project, it will create an unordered list with all the files.

### Example

Let's say we want to create a page and list the images from our `assets/images` folder. The `assets` folder is organized as follows:

```
/assets
  /images
    /Summer
      summer-01.png
      summer-02.png
      /Vacations
        vacations-01.png
    /Autumn
      autumn-01.png
      autumn-02.png
      autumn-03.png
  (...)
```

Inside the `contents` folder, we create an `index.md` file. To list the files from our selected folder all we have to do is write `[download assets/images]`.

The `PicoDownloadList` plugin will convert that shortcode into the following HTML:

```
<ul>
  <li><b>Summer</b></li>
  <ul>
    <li><a href="assets/images/Summer/summer-01.png" download>summer-01</a> [PNG, 1500 KB]</li>
    <li><a href="assets/images/Summer/summer-02.png" download>summer-02</a> [PNG, 1650 KB]</li>
    <li><b>Vacations</b></li>
    <ul>
      <li><a href="assets/images/Summer/Vacations/vacations-01.png" download>vacations-01</a> [PNG, 1800 KB]</li>
  </ul>
  </ul>
  <li><b>Autumn</b></li>
  <ul>
    <li><a href="assets/images/Autumn/autumn-01.png" download>autumn-01</a> [PNG, 1400 KB]</li>
    <li><a href="assets/images/Autumn/autumn-02.png" download>autumn-02</a> [PNG, 1750 KB]</li>
    <li><a href="assets/images/Autumn/autumn-03.png" download>autumn-03</a> [PNG, 1600 KB]</li>
  </ul>
</ul>
```

The final result will be similar to:

* **Summer**
    * [summer-01](/assets/Summer/summer-01.png) [PNG, 1500 KB]
    * [summer-02](/assets/Summer/summer-02.png) [PNG, 1650 KB]
    * **Vacations**
        * [vacations-01](/assets/Summer/Vacations/vacations-01.png) [PNG, 1800 KB]
* **Autumn**
    * [autumn-01](/assets/Autumn/autumn-01.png) [PNG, 1400 KB]
    * [autumn-02](/assets/Autumn/autumn-02.png) [PNG, 1750 KB]
    * [autumn-02](/assets/Autumn/autumn-03.png) [PNG, 1600 KB]
    
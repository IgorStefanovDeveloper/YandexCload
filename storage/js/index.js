import "../scss/styles.scss";
import "../../Modules/Clouddiskprovider/clouddiskprovider.scss";
import "../css/bootstrap.min.css";
import CloudDiskProvider from "../../Modules/Clouddiskprovider/CloudDiskProvider";

window.addEventListener('load', function () {
    let disk = new CloudDiskProvider();
    disk.setObservers();
});

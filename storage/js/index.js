import "../scss/styles.scss";
import "../../Modules/Clouddiskprovider/clouddiskprovider.scss";
import "../css/bootstrap.min.css";
import CloudDiskProvider from "../../Modules/Clouddiskprovider/clouddiskprovider";

window.addEventListener('load', function () {
    let disk = new CloudDiskProvider();
    disk.setObservers();
});

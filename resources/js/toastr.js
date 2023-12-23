import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

export function useToastr() {
    // toastr.options.positionClass = 'toast-top-right';
    toastr.options.closeButton = true;
    toastr.options.progressBar = true;
    return toastr;
}

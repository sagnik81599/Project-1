<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Billing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e8f5e9; /* Light green for hospital feel */
        }

        .billing-section, .summary-section {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .summary-section {
            min-height: 380px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .purchase-btn {
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            background-color: #28a745; /* Green for hospital theme */
            color: white;
            border: none;
        }

        .purchase-btn:hover {
            background-color: #218838;
        }

        .back-btn {
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            background-color: #6c757d;
            color: white;
            border: none;
        }

        .back-btn:hover {
            background-color: #545b62;
        }
    </style>
</head>
<body>

<div class="container my-5">
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
      <div class="card billing-section">
        <div class="card-header bg-success text-white">
          <h5 class="mb-0">Billing Details</h5>
        </div>
        <div class="card-body">
          <form>
            <div class="mb-3">
              <label class="form-label" for="patientID">Patient ID</label>
              <input type="text" id="patientID" class="form-control" placeholder="Enter Patient ID">
            </div>
            
            <div class="mb-3">
              <label class="form-label" for="patientName">Patient Name</label>
              <input type="text" id="patientName" class="form-control" placeholder="Enter Patient Name">
            </div>

            <div class="mb-3">
              <label class="form-label" for="ward">Ward</label>
              <input type="text" id="ward" class="form-control" placeholder="Enter Ward">
            </div>
            
            <div class="mb-3">
              <label class="form-label" for="bedNo">Bed No.</label>
              <input type="text" id="bedNo" class="form-control" placeholder="Enter Bed No.">
            </div>
            
            <div class="mb-3">
              <label class="form-label" for="aadhaarNo">Aadhaar Card No.</label>
              <input type="text" id="aadhaarNo" class="form-control" placeholder="Enter Aadhaar No.">
            </div>

            <div class="mb-3">
              <label class="form-label" for="state">State</label>
              <select id="state" class="form-select">
                <option selected disabled>Choose State</option>
                <option value="CA">California</option>
                <option value="TX">Texas</option>
                <option value="NY">New York</option>
                <option value="FL">Florida</option>
                <option value="IL">Illinois</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label" for="city">City</label>
              <select id="city" class="form-select">
                <option selected disabled>Choose City</option>
                <option value="los_angeles">Los Angeles</option>
                <option value="houston">Houston</option>
                <option value="new_york_city">New York City</option>
                <option value="miami">Miami</option>
                <option value="chicago">Chicago</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label" for="address">Address</label>
              <input type="text" id="address" class="form-control" placeholder="123 Health Street">
            </div>

            <div class="mb-3">
              <label class="form-label" for="email">Email</label>
              <input type="email" id="email" class="form-control" placeholder="example@mail.com">
            </div>

            <div class="mb-3">
              <label class="form-label" for="phone">Phone</label>
              <input type="number" id="phone" class="form-control" placeholder="1234567890">
            </div>

            <div class="mb-3">
              <label class="form-label" for="additionalInfo">Additional Information</label>
              <textarea id="additionalInfo" class="form-control" rows="4" placeholder="E.g., Delivery instructions"></textarea>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-5 col-md-6 col-sm-12">
      <div class="card summary-section">
        <div class="card-header bg-success text-white">
          <h5 class="mb-0">Order Summary</h5>
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
              Medicines <span>$53.98</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              Delivery Charge <span>Free</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <strong>Total (incl. VAT)</strong>
              <span><strong>$53.98</strong></span>
            </li>
          </ul>
          <div class="d-flex justify-content-between gap-3 mt-4">
            <button type="button" class="btn btn-secondary btn-md w-50">Go Back</button>
            <button type="button" class="btn btn-success btn-md w-50">Confirm & Pay</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

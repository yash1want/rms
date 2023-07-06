<div class="tab-content">
  <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
    <div class="main-card mb-3 card">
      <div class="card-body">

        <h4 class="card-title text-white reportHeadingMain">Ticket Reports List</h4>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="tBodyCenter">
              <tr>
                <th>#</th>
                <th>REPORT TITLE</th>
                <th>REPORT NAME</th>
              </tr>
            </thead>
            <tbody class="tBodyCenter">
              <tr>
                <td>1</td>
                <td>TICKET REPORT-FILTER</td>
                <td>
                  <a href="<?= $this->Url->build(['action' => 'all-status-filter', '?' => ['title' => 'report-filter']]) ?>" class="reportLink">Click Here, To Check Ticket Records - Pending ,Inprocess & Closed With Filters.</a>
                </td>
              </tr>
              <!-- <tr>
                <td>4</td>
                <td>REPORT-M04</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M04']]) ?>" class="reportLink">Mine to Smelter Details (Ore to Metal)</a></td>
              </tr> -->
              

              <!-- <tr>
                <td>1b</td>
                <td>REPORT-M01B</td>
                <td>
                  <a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M01b']]) ?>" class="reportLink">Grade wise ROM Dispatch, ROM Ex-Mine Price, Sale Quantity and Value (Minerals other than Iron Ore and Chromite)</a>
                </td>
              </tr>

              <tr>
                <td>2a</td>
                <td>REPORT-M02A</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M02']]) ?>" class="reportLink">Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value(For Iron Ore and Chromite)</a></td>
              </tr>

              <tr>
                <td>2b</td>
                <td>REPORT-M02B</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M02b']]) ?>" class="reportLink">Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (Minerals other than Iron Ore and Chromite)</a></td>
              </tr>
              <tr>
              <tr>
                <td>2c</td>
                <td>REPORT-M02C</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M02c']]) ?>" class="reportLink">Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For F3 Minerals)</a></td>
              </tr>
              <tr>
                <td>3</td>
                <td>REPORT-M03</td>
                <td>
                  <a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M03']]) ?>" class="reportLink"> ROM Opening Stock, ROM Production & ROM Closing Stock</a>
                </td>
              </tr>
              <tr>
                <td>4</td>
                <td>REPORT-M04</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M04']]) ?>" class="reportLink">Mine to Smelter Details (Ore to Metal)</a></td>
              </tr>
              <tr>
                <td>5</td>
                <td>REPORT-M05</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M05']]) ?>" class="reportLink"> Sales-Dispatch Details of Ore/Concentrates</a></td>
              </tr>
              <tr>
                <td>6</td>
                <td>REPORT-M06</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M06']]) ?>" class="reportLink">Opening Stock, Sale of Metal/Product and Closing Stock </a></td>
              </tr>
              <tr>
                <td>7</td>
                <td>REPORT-M07</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M07']]) ?>" class="reportLink">Details of Rent/Royalty/Dead Rent/DMF/NMET</a></td>
              </tr>
              <tr>
                <td>8</td>
                <td>REPORT-M08</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M08']]) ?>" class="reportLink">Precious & Semi Precious Stone ROM Production Details (Form F3)</a></td>
              </tr>
              <tr>
                <td>9</td>
                <td>REPORT-M09</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M09']]) ?>" class="reportLink">Precious & Semi Precious Stone Grade wise Production Details (Form F3)</a></td>
              </tr>
              <tr>
                <td>10</td>
                <td>REPORT-M10</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M10']]) ?>" class="reportLink">Precious & Semi Precious Stone Opening & Closing Stock Details (Form F3)</a></td>
              </tr>
              <tr>
                <td>11</td>
                <td>REPORT-M11</td>
                <td><a href="<?= $this->Url->build(['action' => 'monthly-filter', '?' => ['title' => 'report-M11']]) ?>" class="reportLink">Precious & Semi Precious Stone Ex-Mine Price Details (Form F3)</a></td>
              </tr>

              <tr>
                <td>12a</td>
                <td>REPORT-A01A</td>
                <td>
                  <a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A01a']]) ?>" class="reportLink">Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value(For Iron Ore and Chromite)</a>
                </td>
              </tr>

              <tr>
                <td>12b</td>
                <td>REPORT-A01B</td>
                <td>
                  <a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A01b']]) ?>" class="reportLink">Grade wise ROM Dispatch, ROM Ex-Mine Price, Sale Quantity and Value (Minerals other than Iron Ore and Chromite)</a>
                </td>
              </tr>

              <tr>
                <td>13a</td>
                <td>REPORT - A02A</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A02']]) ?>" class="reportLink">Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value(For Iron Ore and Chromite)</a></td>
              </tr>
              <tr>

              <tr>
                <td>13b</td>
                <td>REPORT-A02B</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A02b']]) ?>" class="reportLink">Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (Minerals other than Iron Ore and Chromite)</a></td>
              </tr>

              <tr>
                <td>13c</td>
                <td>REPORT-A02C</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A02c']]) ?>" class="reportLink">Grade wise Production, Grade wise Dispatch, Grade wise Ex-mine Price, Opening-Closing Stock, Sale Quantity & Value (For F3 Minerals)</a></td>
              </tr>

              <tr>
                <td>14</td>
                <td>REPORT - A03</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A03']]) ?>" class="reportLink">ROM Opening Stock, ROM Production & ROM Closing Stock</a></td>
              </tr>
              <tr> -->
              <!-- <tr>
                <td>15</td>
                <td>REPORT - A04</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A04']]) ?>" class="reportLink">Mine to Smelter Details (Ore to Metal)</a></td>
              </tr> -->
      <!--  <tr>
                <td>16</td>
                <td>REPORT - A05</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A05']]) ?>" class="reportLink">Sales-Dispatch Details of Ore/Concentrates</a></td>
              </tr>
              <tr>
                <td>17</td>
                <td>REPORT - A06</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A06']]) ?>" class="reportLink">Opening Stock, Sale of Metal/Product and Closing Stock</a></td>
              </tr>
              <tr>
                <td>18</td>
                <td>REPORT - A07</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A07']]) ?>" class="reportLink">Details of Rent/Royalty/Dead Rent/DMF/NMET</a></td>
              </tr>
              <tr>
                <td>19</td>
                <td>REPORT - A08</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A08']]) ?>" class="reportLink"> Precious & Semi Precious Stone ROM Production Details (Form F3)</a></td>
              </tr>
              <tr>
                <td>20</td>
                <td>REPORT - A09</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A09']]) ?>" class="reportLink">Precious & Semi Precious Stone Grade wise Production Details (Form F3)</a></td>
              </tr>
              <tr>
                <td>21</td>
                <td>REPORT - A10</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A10']]) ?>" class="reportLink"> Precious & Semi Precious Stone Opening & Closing Stock Details (Form F3)</a></td>
              </tr>
              <tr>
                <td>22</td>
                <td>REPORT - A11</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A11']]) ?>" class="reportLink">Precious & Semi Precious Stone Ex-Mine Price Details (Form F3)</a></td>
              </tr>
              <tr>
                <td>23</td>
                <td>REPORT - A12</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A12']]) ?>" class="reportLink">Reserve & Resources</a></td>
              </tr>
              <tr>
                <td>24</td>
                <td>REPORT - A13</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A13']]) ?>" class="reportLink">Subgrade-Mineral Reject Details</a></td>
              </tr>
              <tr>
                <td>25</td>
                <td>REPORT - A14</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A14']]) ?>" class="reportLink">Tree planted /Survival Rate</a></td>
              </tr>
              <tr>
                <td>26</td>
                <td>REPORT - A15</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A15']]) ?>" class="reportLink">Cost of Production</a></td>
              </tr>
              <tr>
                <td>27</td>
                <td>REPORT - A16</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A16']]) ?>" class="reportLink">Lease area (surface area) Utilization (in hect) at the end of year</a></td>
              </tr>
              <tr>
                <td>28</td>
                <td>REPORT - A17</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A17']]) ?>" class="reportLink" class="reportLink">Miscleaneous</a></td>
              </tr>
              <tr>
                <td>29</td>
                <td>REPORT - A18</td>
                <td><a href="<?= $this->Url->build(['action' => 'annual-filter', '?' => ['title' => 'report-A18']]) ?>" class="reportLink">Machinary used in the Mine</a></td>
              </tr>


              <tr>
                <td>30</td>
                <td>REPORT - M12</td>
                <td><a href="<?= $this->Url->build(['controller' => 'reportsnext', 'action' => 'monthly-filter', '?' => ['title' => 'reportm07']]) ?>" class="reportLink">Mine-wise Average Daily Employment with Male/Female bifurcation</a></td>
              </tr>

              <tr>
                <td>31</td>
                <td>REPORT - M13</td>
                <td><a href="<?= $this->Url->build(['controller' => 'reportsnext', 'action' => 'monthly-filter', '?' => ['title' => 'reportm08']]) ?>" class="reportLink">Mine-wise Average Daily Employment with Direct/Contract bifurcation</a></td>
              </tr>

              <tr>
                <td>32</td>
                <td>REPORT - M14</td>
                <td><a href="<?= $this->Url->build(['controller' => 'reportsnext', 'action' => 'monthly-filter', '?' => ['title' => 'reportm09']]) ?>" class="reportLink">Mine-wise / Work place wise Average Daily Employment and Total Wages paid</a></td>
              </tr>

              <tr>
                <td>33</td>
                <td>REPORT - M15</td>
                <td><a href="<?= $this->Url->build(['controller' => 'reportsnext', 'action' => 'monthly-filter', '?' => ['title' => 'reportm34']]) ?>" class="reportLink">Reasons for increase/decrease in production for the month</a></td>
              </tr>

              <tr>
                <td>34</td>
                <td>REPORT - M16</td>
                <td><a href="<?= $this->Url->build(['controller' => 'reportsnext', 'action' => 'monthly-filter', '?' => ['title' => 'reportm35']]) ?>" class="reportLink">Reasons for increase/decrease in Ex-mine Price for the month</a></td>
              </tr> -->

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
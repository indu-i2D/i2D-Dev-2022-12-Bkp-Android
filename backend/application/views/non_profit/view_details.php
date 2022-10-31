<div class="main-content-inner">
    <div class="card">
        <div class="card-body">
        <a style="float:right; margin-bottom:20px;" class="btn btn-primary" href="<?php echo base_url().'nonprofit/view'; ?>">Back</a>
        </div>
        <div class="row" style="margin:10px;">
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Business Name</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."NAME"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Charity ID</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."CHARITYID"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >EIN</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."EIN"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Description</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."DESCRIPTION"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >ICO</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."ICO"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Address</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."STREET"].", ".$non_profit[DB_prefix."CITY"].", ".$non_profit[DB_prefix."STATE"].", ".$non_profit[DB_prefix."ZIP"].", ".$country["country"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Group</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."GROUP"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Sub Section</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."SUBSECTION"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Affiliation</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."AFFILIATION"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Classification</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."CLASSIFICATION"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Ruling</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."RULING"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Deductibility</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."DEDUCTIBILITY"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Foundation</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."FOUNDATION"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Activity</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."ACTIVITY"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Organization</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."ORGANIZATION"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Status</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."STATUS"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Tax Period</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."TAX_PERIOD"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Asset CD</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."ASSET_CD"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Income CD</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."INCOME_CD"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Filing Req CD</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."FILING_REQ_CD"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >PF Filing Req CD</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."PF_FILING_REQ_CD"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Acct PD</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."ACCT_PD"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Asset Amount</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."ASSET_AMT"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Income Amount</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."INCOME_AMT"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Revenue Amount</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."REVENUE_AMT"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >NTEE CD</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."NTEE_CD"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Short Name</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."SORT_NAME"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >ACT CD1</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."ACT_CD1"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >ACT CD2</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."ACT_CD2"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >ACT CD3</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."ACT_CD3"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Branch NM</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."BRANCH_NM"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >Branch CD</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."BRANCH_CD"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >EO ID Full</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."EO_ID_FULL"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >EO ID</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."EO_ID"]; ?></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="row">
                    <div class="col-sm-12 col-md-6" >NTEE DREV CD</div>
                    <div class="col-sm-12 col-md-6" > : <?php echo $non_profit[DB_prefix."NTEE_DERV_CD"]; ?></div>
                </div>
            </div>
        </div>

    </div>
</div>
<style>
    .col-sm-6 .row{
        margin-bottom:10px;
        font-size:16px;
    }
</style>